@php
    $navCategories = \App\Models\Category::query()->orderBy('name')->take(8)->get();
    $cartCount = app(\App\Support\Cart::class)->count();
    $shopLink = route('products.index');
    $ordersLink = auth()->check() ? route('account.orders.index') : route('login');
    $accountLink = auth()->check() ? route('account.orders.index') : route('login');
@endphp

<header class="sticky top-0 z-40">
    <div class="header-topbar relative overflow-hidden text-white">
        <div class="header-topbar-shimmer" aria-hidden="true"></div>
        <div class="shell relative flex min-h-10 items-center justify-center py-2 text-center text-[11px] font-medium uppercase tracking-[0.22em] text-white/90 sm:text-xs">
            <span>Free shipping over $75</span>
            <span class="mx-3 text-white/35">•</span>
            <span>Cash on delivery available</span>
            <span class="mx-3 hidden text-white/35 sm:inline">•</span>
            <span class="hidden sm:inline">Fresh-clean formulas for modern homes</span>
        </div>
    </div>

    <div class="shell pt-3">
        <div class="header-shell">
            <div class="flex items-center justify-between gap-4 lg:grid lg:grid-cols-[auto_1fr_auto] lg:gap-8">
                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        class="header-icon-button lg:hidden"
                        data-mobile-toggle
                        aria-label="Open menu"
                        aria-expanded="false"
                    >
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>

                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/spray-wow-logo-500.webp') }}" alt="SprayWow" class="h-14 w-auto sm:h-16">
                    </a>
                </div>

                <nav class="hidden items-center justify-center gap-8 lg:flex">
                    <a href="{{ route('home') }}" class="header-nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
                    <a href="{{ $shopLink }}" class="header-nav-link {{ request()->routeIs('products.*') ? 'is-active' : '' }}">Shop</a>
                    <a href="{{ route('blog.index') }}" class="header-nav-link {{ request()->routeIs('blog.*') ? 'is-active' : '' }}">Blog</a>
                    <a href="{{ route('about') }}" class="header-nav-link {{ request()->routeIs('about') ? 'is-active' : '' }}">About</a>
                    <div class="relative" data-dropdown>
                        <button
                            type="button"
                            class="header-nav-link inline-flex items-center gap-2"
                            data-dropdown-trigger
                            aria-expanded="false"
                        >
                            Categories
                            <svg viewBox="0 0 20 20" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <path d="m5 8 5 5 5-5" />
                            </svg>
                        </button>

                        <div class="header-dropdown hidden" data-dropdown-panel>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach($navCategories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="header-dropdown-item">
                                        <span class="header-dropdown-title">{{ $category->name }}</span>
                                        <span class="header-dropdown-copy">Explore SprayWow picks for {{ strtolower($category->name) }}.</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a href="{{ $ordersLink }}" class="header-nav-link {{ request()->routeIs('account.orders.*') ? 'is-active' : '' }}">Orders</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <form action="{{ route('products.index') }}" method="GET" class="hidden xl:block">
                        <div class="header-search">
                            <svg viewBox="0 0 24 24" class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <circle cx="11" cy="11" r="6"></circle>
                                <path d="m20 20-3.5-3.5"></path>
                            </svg>
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Search products"
                                class="w-44 border-0 bg-transparent text-sm text-slate-800 outline-none ring-0 placeholder:text-slate-400"
                            >
                            <button type="submit" class="header-search-button">Search</button>
                        </div>
                    </form>

                    <a href="{{ $accountLink }}" class="header-icon-button" title="{{ auth()->check() ? 'Account' : 'Login' }}" aria-label="{{ auth()->check() ? 'Account' : 'Login' }}">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
                            <path d="M5 20a7 7 0 0 1 14 0"></path>
                        </svg>
                    </a>

                    <a href="{{ $ordersLink }}" class="header-icon-button" title="Orders" aria-label="Orders">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M8 7h8"></path>
                            <path d="M8 11h8"></path>
                            <path d="M8 15h5"></path>
                            <path d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"></path>
                        </svg>
                    </a>

                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="header-icon-button hidden sm:inline-flex" title="Admin" aria-label="Admin">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <path d="M12 3 4 7v6c0 4.4 3.4 8.4 8 9 4.6-.6 8-4.6 8-9V7l-8-4Z"></path>
                                    <path d="m9.5 12 1.7 1.7 3.3-3.7"></path>
                                </svg>
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('cart.index') }}" class="header-cart-button" title="Cart" aria-label="Cart">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <circle cx="9" cy="19" r="1.5"></circle>
                            <circle cx="18" cy="19" r="1.5"></circle>
                            <path d="M3.5 4h2l2.3 9.3a1 1 0 0 0 1 .7h8.9a1 1 0 0 0 1-.8L20 7H7.1"></path>
                        </svg>
                        <span class="header-cart-badge">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>

            <div class="mt-4 border-t border-white/60 pt-4 lg:hidden">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="header-search">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <circle cx="11" cy="11" r="6"></circle>
                            <path d="m20 20-3.5-3.5"></path>
                        </svg>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Search products"
                            class="w-full border-0 bg-transparent text-sm text-slate-800 outline-none ring-0 placeholder:text-slate-400"
                        >
                        <button type="submit" class="header-search-button">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-mobile-backdrop hidden" data-mobile-backdrop></div>
    <aside class="header-mobile-drawer hidden" data-mobile-drawer>
        <div class="flex items-center justify-between border-b border-sky-100 px-5 py-5">
            <img src="{{ asset('images/spray-wow-logo-500.webp') }}" alt="SprayWow" class="h-10 w-auto">
            <button
                type="button"
                class="header-icon-button"
                data-mobile-close
                aria-label="Close menu"
            >
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M6 6 18 18M18 6 6 18" />
                </svg>
            </button>
        </div>

        <div class="flex flex-col gap-6 px-5 py-6">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="header-search">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-sky-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <circle cx="11" cy="11" r="6"></circle>
                        <path d="m20 20-3.5-3.5"></path>
                    </svg>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Search products"
                        class="w-full border-0 bg-transparent text-sm text-slate-800 outline-none ring-0 placeholder:text-slate-400"
                    >
                    <button type="submit" class="header-search-button">Search</button>
                </div>
            </form>

            <nav class="flex flex-col gap-4 text-base font-medium text-slate-800">
                <a href="{{ route('home') }}" class="header-mobile-link">Home</a>
                <a href="{{ $shopLink }}" class="header-mobile-link">Shop All</a>
                <a href="{{ route('blog.index') }}" class="header-mobile-link">Blog</a>
                <a href="{{ route('about') }}" class="header-mobile-link">About Us</a>
                <a href="{{ $ordersLink }}" class="header-mobile-link">Orders</a>
                <div class="rounded-3xl border border-sky-100 bg-sky-50/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-600">Categories</p>
                    <div class="mt-3 flex flex-col gap-3">
                        @foreach($navCategories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="header-mobile-link">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ $accountLink }}" class="header-mobile-action">
                    <span>Account</span>
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"></path>
                        <path d="M5 20a7 7 0 0 1 14 0"></path>
                    </svg>
                </a>
                <a href="{{ route('cart.index') }}" class="header-mobile-action">
                    <span>Cart</span>
                    <span class="rounded-full bg-rose-500 px-2 py-0.5 text-xs font-semibold text-white">{{ $cartCount }}</span>
                </a>
            </div>
        </div>
    </aside>
</header>
