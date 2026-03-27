@extends('account.layout')

@section('title', 'My Orders')
@section('kicker', 'Customer Dashboard')
@section('heading', 'My Orders')

@section('content')
    <div class="dashboard-grid-metrics">
        <div class="metric-card">
            <p class="metric-label">Total Orders</p>
            <p class="metric-value">{{ $orderStats['total_orders'] }}</p>
            <p class="metric-meta">Everything you have purchased from SprayWow.</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Active Orders</p>
            <p class="metric-value">{{ $orderStats['active_orders'] }}</p>
            <p class="metric-meta">Orders currently being processed or shipped.</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Total Spend</p>
            <p class="metric-value">${{ number_format($orderStats['total_spend'], 2) }}</p>
            <p class="metric-meta">Your current lifetime spend with SprayWow.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">My Orders</p>
                    <h2 class="dashboard-section-title">Recent purchases</h2>
                </div>
            </div>

            <div class="dashboard-table-wrap mt-6">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('account.orders.show', $order) }}" class="font-semibold text-slate-950">{{ $order->order_number }}</a>
                                    <p class="mt-1 text-xs text-slate-400">{{ optional($order->placed_at)->format('M d, Y') }}</p>
                                </td>
                                <td><span class="dashboard-status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">You have not placed any orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $orders->links() }}</div>
        </section>

        <div class="space-y-6">
            <section class="dashboard-panel">
                <div class="dashboard-panel-head">
                    <div>
                        <p class="dashboard-section-kicker">Account Info</p>
                        <h2 class="dashboard-section-title">Profile summary</h2>
                    </div>
                </div>
                <div class="mt-5 rounded-[24px] border border-sky-100 bg-sky-50/60 p-5 text-sm text-slate-600">
                    <p class="font-semibold text-slate-950">{{ auth()->user()->name }}</p>
                    <p class="mt-2">{{ auth()->user()->email }}</p>
                    <p>{{ auth()->user()->phone ?: 'No phone number saved yet' }}</p>
                </div>
            </section>

            <section class="dashboard-panel">
                <div class="dashboard-panel-head">
                    <div>
                        <p class="dashboard-section-kicker">Saved Addresses</p>
                        <h2 class="dashboard-section-title">Latest shipping address</h2>
                    </div>
                </div>
                <div class="mt-5 rounded-[24px] border border-sky-100 bg-sky-50/60 p-5 text-sm text-slate-600">
                    @if($savedAddress)
                        <p class="font-semibold text-slate-950">{{ $savedAddress->shipping_name }}</p>
                        <p class="mt-2">{{ $savedAddress->shipping_address }}</p>
                        <p>{{ $savedAddress->shipping_city }}, {{ $savedAddress->shipping_state }} {{ $savedAddress->shipping_zip }}</p>
                    @else
                        <p>No saved shipping address available yet. It will appear after your first completed checkout.</p>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
