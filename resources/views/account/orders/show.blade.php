@extends('account.layout')

@section('title', $order->order_number)
@section('kicker', 'Order Details')
@section('heading', $order->order_number)

@section('header_actions')
    <a href="{{ route('account.orders.invoice', $order) }}" class="btn-secondary !px-4 !py-2">Invoice</a>
@endsection

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">My Order</p>
                    <h2 class="dashboard-section-title">Items and status</h2>
                </div>
                <a href="{{ route('account.orders.index') }}" class="dashboard-inline-link">Back to orders</a>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="metric-card !p-5">
                    <p class="metric-label">Status</p>
                    <span class="dashboard-status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="metric-card !p-5">
                    <p class="metric-label">Payment</p>
                    <p class="mt-3 font-semibold text-slate-950">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p>
                </div>
                <div class="metric-card !p-5">
                    <p class="metric-label">Placed</p>
                    <p class="mt-3 font-semibold text-slate-950">{{ optional($order->placed_at)->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                @foreach($order->items as $item)
                    <div class="inventory-row">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $item->product_name }}</p>
                            <p class="text-sm text-slate-500">Qty {{ $item->quantity }}</p>
                        </div>
                        <span class="font-semibold text-slate-950">${{ number_format($item->line_total, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Summary</p>
                    <h2 class="dashboard-section-title">Billing and shipping</h2>
                </div>
            </div>

            <div class="mt-5 rounded-[24px] border border-sky-100 bg-sky-50/60 p-5 text-sm text-slate-600">
                <div class="space-y-3">
                    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($order->shipping_total, 2) }}</span></div>
                    <div class="flex justify-between"><span>Discount</span><span>- ${{ number_format($order->discount_total, 2) }}</span></div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-semibold text-slate-950"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
                </div>

                <div class="mt-6">
                    <p class="font-semibold text-slate-950">Shipping address</p>
                    <p class="mt-2">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                </div>
            </div>
        </section>
    </div>
@endsection
