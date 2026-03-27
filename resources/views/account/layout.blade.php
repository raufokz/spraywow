<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'My Account') | SprayWow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell">
    @php
        $accountNav = [
            ['label' => 'My Orders', 'route' => 'account.orders.index', 'active' => request()->routeIs('account.orders.*'), 'icon' => 'orders'],
            ['label' => 'Account Info', 'route' => 'profile.edit', 'active' => request()->routeIs('profile.*'), 'icon' => 'customers'],
            ['label' => 'Saved Addresses', 'route' => 'account.orders.index', 'active' => false, 'icon' => 'categories'],
            ['label' => 'Storefront', 'route' => 'home', 'active' => false, 'icon' => 'dashboard'],
        ];
    @endphp

    <div class="dashboard-app dashboard-app-has-sidebar">
        <div class="dashboard-backdrop hidden" data-dashboard-backdrop></div>

        <aside class="dashboard-sidebar dashboard-sidebar-user dashboard-sidebar-collapsible is-collapsed" data-dashboard-sidebar>
            <div>
                <a href="{{ route('account.orders.index') }}" class="dashboard-brand">
                    <img src="{{ asset('images/spray-wow-logo-500.webp') }}" alt="SprayWow" class="h-12 w-auto">
                </a>
                <p class="dashboard-sidebar-kicker mt-4 text-xs font-semibold uppercase tracking-[0.24em] text-sky-200/80" data-dashboard-label>My account</p>

                <nav class="mt-8 space-y-2">
                    @foreach($accountNav as $item)
                        <a href="{{ route($item['route']) }}" class="dashboard-nav-link {{ $item['active'] ? 'is-active' : '' }}" title="{{ $item['label'] }}">
                            <span class="dashboard-nav-icon">@include('admin.partials.icon', ['name' => $item['icon']])</span>
                            <span data-dashboard-label>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="dashboard-sidebar-foot">
                <div class="dashboard-user-card">
                    <p class="text-sm font-semibold text-white" data-dashboard-label>{{ auth()->user()->name }}</p>
                    <p class="mt-1 text-sm text-slate-300" data-dashboard-label>{{ auth()->user()->email }}</p>
                    <p class="dashboard-footer-short text-sm font-semibold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</p>
                </div>
            </div>
        </aside>

        <div class="dashboard-main">
            <div class="dashboard-topbar">
                <div>
                    <button type="button" class="dashboard-menu-button" data-dashboard-toggle aria-label="Toggle account menu" aria-expanded="false">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                    <p class="dashboard-kicker">@yield('kicker', 'Customer Area')</p>
                    <h1 class="dashboard-title">@yield('heading', 'My Account')</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @yield('header_actions')
                    <a href="{{ route('products.index') }}" class="dashboard-secondary-link">Shop more</a>
                </div>
            </div>

            <main class="dashboard-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
