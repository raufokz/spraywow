<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Account Access' }} | SprayWow</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-shell">
        <main class="auth-page">
            <section class="auth-hero" aria-hidden="true">
                <a href="{{ route('home') }}" class="auth-brand">
                    <span class="auth-brand-mark">
                        <img src="{{ asset('images/spraywow.webp') }}" alt="SprayWow logo" class="auth-brand-logo">
                    </span>
                    <div>
                        <span class="auth-brand-kicker">spraywow.com</span>
                        <span class="auth-brand-name">SprayWow</span>
                    </div>
                </a>

                <div class="auth-hero-copy">
                    <p class="auth-eyebrow">Fresh access</p>
                    <h1 class="auth-hero-title">{{ $heading ?? 'Welcome back to cleaner shopping' }}</h1>
                    <p class="auth-hero-text">
                        {{ $subheading ?? 'Manage orders, revisit products, and move through checkout faster with a smoother account experience.' }}
                    </p>
                </div>

                <div class="auth-benefits">
                    <div class="auth-benefit-card">
                        <p class="auth-benefit-title">Faster checkout</p>
                        <p class="auth-benefit-text">Save your details and return to your cart without starting over.</p>
                    </div>
                    <div class="auth-benefit-card">
                        <p class="auth-benefit-title">Order tracking</p>
                        <p class="auth-benefit-text">Keep all your purchases, invoices, and updates in one clean place.</p>
                    </div>
                    <div class="auth-benefit-card">
                        <p class="auth-benefit-title">Premium care picks</p>
                        <p class="auth-benefit-text">Get back to the products you already know work well for your routine.</p>
                    </div>
                </div>
            </section>

            <section class="auth-card-wrap">
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
