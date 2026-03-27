@extends('admin.layout')

@section('title', $order->order_number)
@section('kicker', 'Order Details')
@section('heading', $order->order_number)

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Line Items</p>
                    <h2 class="dashboard-section-title">Order contents</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="dashboard-inline-link">Back to orders</a>
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
                    <p class="dashboard-section-kicker">Order Controls</p>
                    <h2 class="dashboard-section-title">Status and customer</h2>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-6 space-y-4">
                @csrf
                @method('PUT')
                <select name="status" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                    @foreach(['processing','packed','shipped','delivered','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <select name="payment_status" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                    @foreach(['awaiting_payment','pending','paid','refunded'] as $status)
                        <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
                <button class="btn-primary w-full">Update order</button>
            </form>

            <div class="mt-6 rounded-[24px] border border-sky-100 bg-sky-50/60 p-5 text-sm text-slate-600">
                <p class="font-semibold text-slate-950">Customer</p>
                <p class="mt-2">{{ $order->billing_name }}</p>
                <p>{{ $order->billing_email }}</p>
                <p>{{ $order->billing_phone }}</p>

                <p class="mt-5 font-semibold text-slate-950">Shipping</p>
                <p class="mt-2">{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
            </div>
        </section>
    </div>
@endsection
