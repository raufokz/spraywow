<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | SprayWow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell">
    @php
        $adminNav = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => request()->routeIs('admin.dashboard'), 'icon' => 'dashboard'],
            ['label' => 'Products', 'route' => 'admin.products.index', 'active' => request()->routeIs('admin.products.*'), 'icon' => 'products'],
            ['label' => 'Categories', 'route' => 'admin.categories.index', 'active' => request()->routeIs('admin.categories.*'), 'icon' => 'categories'],
            ['label' => 'Blog', 'route' => 'admin.blog.posts.index', 'active' => request()->routeIs('admin.blog.*'), 'icon' => 'blog'],
            ['label' => 'Orders', 'route' => 'admin.orders.index', 'active' => request()->routeIs('admin.orders.*'), 'icon' => 'orders'],
            ['label' => 'Customers', 'route' => 'admin.users.index', 'active' => request()->routeIs('admin.users.*'), 'icon' => 'customers'],
            ['label' => 'Settings', 'route' => 'profile.edit', 'active' => request()->routeIs('profile.*') || request()->routeIs('admin.coupons.*'), 'icon' => 'settings'],
        ];
    @endphp

    <div class="dashboard-app dashboard-app-has-sidebar">
        <div class="dashboard-backdrop hidden" data-dashboard-backdrop></div>

        <aside class="dashboard-sidebar dashboard-sidebar-collapsible is-collapsed" data-dashboard-sidebar>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="dashboard-brand">
                    <img src="{{ asset('images/spray-wow-logo-500.webp') }}" alt="SprayWow" class="h-12 w-auto">
                </a>
                <p class="dashboard-sidebar-kicker mt-4 text-xs font-semibold uppercase tracking-[0.24em] text-sky-200/80" data-dashboard-label>Admin workspace</p>

                <nav class="mt-8 space-y-2">
                    @foreach($adminNav as $item)
                        <a href="{{ route($item['route']) }}" class="dashboard-nav-link {{ $item['active'] ? 'is-active' : '' }}" title="{{ $item['label'] }}">
                            <span class="dashboard-nav-icon">@include('admin.partials.icon', ['name' => $item['icon']])</span>
                            <span data-dashboard-label>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="dashboard-sidebar-foot">
                <a href="{{ route('home') }}" class="dashboard-secondary-link" data-dashboard-footer-link>
                    <span data-dashboard-label>View storefront</span>
                    <span class="dashboard-footer-short">Home</span>
                </a>
            </div>
        </aside>

        <div class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <button type="button" class="dashboard-menu-button" data-dashboard-toggle aria-label="Toggle dashboard menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                    <p class="dashboard-kicker">@yield('kicker', 'Admin')</p>
                    <h1 class="dashboard-title">@yield('heading', 'Dashboard')</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @yield('header_actions')
                    <a href="{{ route('profile.edit') }}" class="dashboard-profile-pill">
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                </div>
            </div>

            <main class="dashboard-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
