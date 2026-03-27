<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'SprayWow Admin' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="admin-shell">
        <div class="grid min-h-screen lg:grid-cols-[260px_1fr]">
            <aside class="border-r border-slate-200 bg-slate-950 px-6 py-8 text-slate-200">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-linear-to-br from-cyan-400 to-blue-600 font-bold text-slate-950">SW</span>
                    <div>
                        <span class="block text-xs uppercase tracking-[0.32em] text-cyan-200/70">Admin</span>
                        <span class="text-lg font-semibold text-white">SprayWow</span>
                    </div>
                </a>
                <nav class="mt-8 space-y-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Products</a>
                    <a href="{{ route('admin.categories.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Categories</a>
                    <a href="{{ route('admin.orders.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Orders</a>
                    <a href="{{ route('admin.coupons.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Coupons</a>
                    <a href="{{ route('admin.users.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Users</a>
                    <a href="{{ route('home') }}" class="block rounded-2xl px-4 py-3 hover:bg-white/8">Storefront</a>
                </nav>
            </aside>
            <div class="p-6 lg:p-10">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ $errors->first() }}</div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
