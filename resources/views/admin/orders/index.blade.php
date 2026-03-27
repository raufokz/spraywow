@extends('admin.layout')

@section('title', 'Orders')
@section('kicker', 'Order Management')
@section('heading', 'Orders')

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">Fulfillment Queue</p>
                <h2 class="dashboard-section-title">Recent customer orders</h2>
            </div>
        </div>

        <div class="dashboard-table-wrap mt-6">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <p class="font-semibold text-slate-950">{{ $order->order_number }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ optional($order->placed_at)->format('M d, Y') }}</p>
                            </td>
                            <td>{{ $order->billing_name }}</td>
                            <td><span class="dashboard-status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-semibold text-sky-700">Open</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    </section>
@endsection
