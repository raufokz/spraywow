<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderPlacedNotification;
use App\Support\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\StripeClient;
use Throwable;

class CheckoutController extends Controller
{
    public function create(Cart $cart): View|RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        return view('storefront.checkout.index', ['cart' => $cart->summary()]);
    }

    public function store(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('cart.index');
        }

        $validated = $request->validate([
            'billing_name' => ['required', 'string', 'max:255'],
            'billing_email' => ['required', 'email'],
            'billing_phone' => ['required', 'string', 'max:30'],
            'billing_address' => ['required', 'string', 'max:255'],
            'billing_city' => ['required', 'string', 'max:120'],
            'billing_state' => ['required', 'string', 'max:120'],
            'billing_zip' => ['required', 'string', 'max:20'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:120'],
            'shipping_state' => ['required', 'string', 'max:120'],
            'shipping_zip' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:cod,stripe'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $summary = $cart->summary();
        $stripeConfigured = filled(config('services.stripe.secret')) && filled(config('services.stripe.key'));

        if ($validated['payment_method'] === 'stripe' && ! $stripeConfigured) {
            return back()->withErrors(['payment_method' => 'Stripe is not configured yet. Add STRIPE_KEY and STRIPE_SECRET to continue.'])->withInput();
        }

        $order = DB::transaction(function () use ($request, $validated, $summary) {
            $order = Order::create([
                ...$validated,
                'user_id' => $request->user()?->id,
                'coupon_id' => $summary['coupon']?->id,
                'order_number' => 'SW-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT),
                'status' => 'processing',
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'awaiting_payment',
                'subtotal' => $summary['subtotal'],
                'discount_total' => $summary['discount_total'],
                'shipping_total' => $summary['shipping_total'],
                'total' => $summary['total'],
                'placed_at' => now(),
            ]);

            foreach ($summary['items'] as $item) {
                $product = $item['product'];
                $product->decrement('stock', $item['quantity']);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                ]);
            }

            if ($summary['coupon']) {
                $summary['coupon']->increment('used_count');
            }

            return $order->load('items.product');
        });

        if ($validated['payment_method'] === 'stripe') {
            try {
                $session = (new StripeClient(config('services.stripe.secret')))->checkout->sessions->create([
                    'mode' => 'payment',
                    'success_url' => route('checkout.stripe.success', $order).'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('checkout.stripe.cancel', $order),
                    'customer_email' => $order->billing_email,
                    'metadata' => ['order_id' => $order->id],
                    'line_items' => $order->items->map(fn ($item) => [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => ['name' => $item->product_name],
                            'unit_amount' => (int) round(((float) $item->unit_price) * 100),
                        ],
                        'quantity' => $item->quantity,
                    ])->values()->all(),
                ]);

                $order->update(['stripe_session_id' => $session->id]);

                return redirect($session->url);
            } catch (Throwable) {
                return redirect()->route('checkout.index')->withErrors(['payment_method' => 'Stripe checkout could not be started. Please try again or switch to Cash on Delivery.']);
            }
        }

        $cart->flush();
        Notification::route('mail', $order->billing_email)->notify(new OrderPlacedNotification($order));

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order, Cart $cart): View
    {
        $cart->flush();

        return view('storefront.checkout.success', compact('order'));
    }

    public function stripeSuccess(Request $request, Order $order, Cart $cart): RedirectResponse
    {
        $sessionId = $request->string('session_id')->toString();

        if ($sessionId && config('services.stripe.secret')) {
            try {
                $session = (new StripeClient(config('services.stripe.secret')))->checkout->sessions->retrieve($sessionId);

                if ($session instanceof StripeSession && $session->payment_status === 'paid') {
                    $order->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                    ]);
                }
            } catch (Throwable) {
                //
            }
        }

        Notification::route('mail', $order->billing_email)->notify(new OrderPlacedNotification($order));
        $cart->flush();

        return redirect()->route('checkout.success', $order);
    }

    public function stripeCancel(Order $order): RedirectResponse
    {
        return redirect()->route('checkout.index')->withErrors(['payment_method' => "Stripe checkout was canceled for order {$order->order_number}."]);
    }
}
