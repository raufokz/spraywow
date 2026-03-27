<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', ['orders' => Order::query()->latest()->paginate(12)]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load('items.product', 'user')]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:processing,packed,shipped,delivered,cancelled'],
            'payment_status' => ['required', 'in:awaiting_payment,pending,paid,refunded'],
        ]);

        if ($validated['payment_status'] === 'paid' && ! $order->paid_at) {
            $validated['paid_at'] = now();
        }

        $order->update($validated);

        return back()->with('success', 'Order updated.');
    }
}
