<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountOrderController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $orders = $user->orders()->latest()->paginate(10);
        $latestAddressOrder = $user->orders()
            ->whereNotNull('shipping_address')
            ->latest('placed_at')
            ->first();

        return view('account.orders.index', [
            'orders' => $orders,
            'orderStats' => [
                'recent' => $user->orders()->latest()->take(3)->get(),
                'total_orders' => $user->orders()->count(),
                'total_spend' => $user->orders()->sum('total'),
                'active_orders' => $user->orders()->whereNotIn('status', ['delivered', 'cancelled'])->count(),
            ],
            'savedAddress' => $latestAddressOrder,
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->is_admin, 403);

        return view('account.orders.show', [
            'order' => $order->load('items.product'),
        ]);
    }

    public function invoice(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id || $request->user()->is_admin, 403);

        return view('account.orders.invoice', [
            'order' => $order->load('items.product'),
        ]);
    }
}
