@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('kicker', 'SprayWow Control Room')
@section('heading', 'Dashboard Overview')

@section('header_actions')
    <a href="{{ route('admin.products.create') }}" class="btn-primary">New product</a>
@endsection

@section('content')
    <div class="dashboard-grid-metrics">
        <div class="metric-card">
            <p class="metric-label">Total Revenue</p>
            <p class="metric-value">${{ number_format($stats['sales'], 2) }}</p>
            <p class="metric-meta">Healthy paid and fulfilled order volume.</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Total Orders</p>
            <p class="metric-value">{{ $stats['orders'] }}</p>
            <p class="metric-meta">Track every fulfillment step in one place.</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Total Products</p>
            <p class="metric-value">{{ $stats['products'] }}</p>
            <p class="metric-meta">Catalog items currently managed in-store.</p>
        </div>
        <div class="metric-card">
            <p class="metric-label">Active Users</p>
            <p class="metric-value">{{ $stats['customers'] }}</p>
            <p class="metric-meta">Customer accounts available in SprayWow.</p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.35fr_.95fr]">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Sales Performance</p>
                    <h2 class="dashboard-section-title">Revenue trend</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="dashboard-inline-link">View orders</a>
            </div>
            @php($maxRevenue = max($salesByMonth->pluck('revenue')->all() ?: [1]))
            <div class="chart-bars mt-8">
                @foreach($salesByMonth as $month)
                    <div class="chart-bar-col">
                        <div class="chart-bar-shell">
                            <div class="chart-bar-fill" style="height: {{ max(14, ($month->revenue / $maxRevenue) * 100) }}%"></div>
                        </div>
                        <p class="mt-3 text-sm font-medium text-slate-600">{{ $month->month }}</p>
                        <p class="text-xs text-slate-400">${{ number_format($month->revenue, 0) }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Status Snapshot</p>
                    <h2 class="dashboard-section-title">Order breakdown</h2>
                </div>
            </div>
            <div class="mt-6 space-y-3">
                @foreach($statusBreakdown as $status => $total)
                    <div class="status-breakdown-row">
                        <div>
                            <p class="font-semibold capitalize text-slate-900">{{ str_replace('_', ' ', $status) }}</p>
                            <p class="text-sm text-slate-500">Current order volume</p>
                        </div>
                        <span class="dashboard-status-badge status-{{ $status }}">{{ $total }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-[1.3fr_.7fr]">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Recent Activity</p>
                    <h2 class="dashboard-section-title">Latest orders</h2>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="dashboard-inline-link">Manage all</a>
            </div>

            <div class="dashboard-table-wrap mt-6">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-slate-950">{{ $order->order_number }}</a>
                                    <p class="mt-1 text-xs text-slate-400">{{ optional($order->placed_at)->format('M d, Y') }}</p>
                                </td>
                                <td>{{ $order->billing_name }}</td>
                                <td><span class="dashboard-status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>${{ number_format($order->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">Inventory Watch</p>
                    <h2 class="dashboard-section-title">Low stock</h2>
                </div>
                <a href="{{ route('admin.products.index') }}" class="dashboard-inline-link">Open products</a>
            </div>
            <div class="mt-6 space-y-3">
                @foreach($lowStockProducts as $product)
                    <div class="inventory-row">
                        <div>
                            <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                            <p class="text-sm text-slate-500">{{ $product->sku ?: 'No SKU' }}</p>
                        </div>
                        <span class="inventory-pill">{{ $product->stock }} left</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
