<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $metaTitle ?? 'SprayWow | Premium Cleaning Sprays' }}</title>
        <meta name="description" content="{{ $metaDescription ?? 'SprayWow sells premium cleaning sprays for shoes, kitchens, glass, cars, fabrics, and more.' }}">
        <script type="application/ld+json">
            {!! json_encode(['@context' => 'https://schema.org','@type' => 'Store','name' => 'SprayWow','url' => config('app.url'),'description' => 'Premium cleaning spray brand and online store.'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/70 backdrop-blur-xl">
            <div class="shell flex items-center justify-between gap-4 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-linear-to-br from-cyan-400 to-blue-600 text-lg font-bold text-slate-950">SW</span>
                    <div>
                        <span class="block text-xs uppercase tracking-[0.32em] text-cyan-200/70">spraywow.com</span>
                        <span class="text-lg font-semibold">SprayWow</span>
                    </div>
                </a>
                <nav class="hidden items-center gap-6 text-sm text-slate-200 md:flex">
                    <a href="{{ route('products.index') }}" class="hover:text-cyan-200">Shop</a>
                    <a href="{{ route('products.index', ['category' => 'kitchen-care']) }}" class="hover:text-cyan-200">Kitchen</a>
                    <a href="{{ route('products.index', ['category' => 'shoe-care']) }}" class="hover:text-cyan-200">Shoe Care</a>
                    <a href="{{ route('products.index', ['category' => 'auto-care']) }}" class="hover:text-cyan-200">Auto</a>
                </nav>
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn-secondary !px-4 !py-2">Admin</a>
                        @endif
                        <a href="{{ route('account.orders.index') }}" class="btn-secondary !px-4 !py-2">Account</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary !px-4 !py-2">Login</a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="btn-primary !px-4 !py-2">Cart ({{ app(\App\Support\Cart::class)->count() }})</a>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="shell pt-4">
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="shell pt-4">
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ $errors->first() }}</div>
            </div>
        @endif

        <main>{{ $slot }}</main>

        <footer class="mt-20 bg-slate-950 py-12 text-slate-300">
            <div class="shell grid gap-8 md:grid-cols-3">
                <div>
                    <h3 class="text-xl font-semibold text-white">SprayWow</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">Luxury-feel cleaning sprays for modern homes, closets, and cars. Fresh formulas. Sharp design. Real results.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white">Shop</h4>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-cyan-200">All products</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-cyan-200">Cart</a></li>
                        <li><a href="{{ route('account.orders.index') }}" class="hover:text-cyan-200">Orders</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white">Trust</h4>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li>Secure Stripe checkout</li>
                        <li>Cash on Delivery available</li>
                        <li>Support: hello@spraywow.com</li>
                    </ul>
                </div>
            </div>
        </footer>
    </body>
</html>
