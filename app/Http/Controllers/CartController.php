<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Cart $cart): View
    {
        return view('storefront.cart.index', ['cart' => $cart->summary()]);
    }

    public function store(Request $request, Product $product, Cart $cart): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
        abort_if($product->stock < 1, 422, 'This product is currently out of stock.');
        $cart->add($product, $validated['quantity'] ?? 1);

        return back()->with('success', "{$product->name} added to cart.");
    }

    public function update(Request $request, Product $product, Cart $cart): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:0']]);
        $cart->update($product, $validated['quantity']);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Product $product, Cart $cart): RedirectResponse
    {
        $cart->remove($product);

        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request, Cart $cart): RedirectResponse
    {
        $validated = $request->validate(['code' => ['required', 'string']]);
        $coupon = Coupon::query()->where('code', strtoupper($validated['code']))->first();

        if (! $coupon || ! $coupon->isValidFor($cart->subtotal())) {
            return back()->withErrors(['code' => 'That promo code is invalid or does not meet the minimum order value.']);
        }

        $cart->setCoupon($coupon);

        return back()->with('success', 'Promo code applied.');
    }

    public function removeCoupon(Cart $cart): RedirectResponse
    {
        $cart->setCoupon(null);

        return back()->with('success', 'Promo code removed.');
    }
}
