<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.seo', [
        'title' => 'About SprayWow | Modern Cleaning Solutions',
        'description' => 'Learn more about SprayWow, our mission, vision, and the fresh approach behind our modern cleaning solutions.',
        'keywords' => 'about SprayWow, cleaning brand, cleaning solutions company',
        'canonical' => route('about'),
        'type' => 'website',
    ])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <section class="shell hero-band pb-10 pt-8 sm:pb-14 sm:pt-10">
        <div class="about-hero reveal">
            <div class="about-hero-copy">
                <span class="eyebrow">About SprayWow</span>
                <h1 class="text-balance text-4xl font-semibold text-white sm:text-5xl xl:text-6xl">Making Cleaning Smarter and Easier</h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                    SprayWow was built around one simple idea: everyday cleaning should feel faster, fresher, and more dependable. We design products that look modern, work hard, and help homes stay effortlessly clean.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn-primary">Shop Now</a>
                    <a href="{{ route('products.index') }}" class="btn-secondary">Explore Products</a>
                </div>
            </div>
            <div class="about-hero-panel">
                <div class="about-floating-logo">
                    <img src="{{ asset('images/spray-wow-logo-500.webp') }}" alt="SprayWow" class="h-28 w-auto sm:h-32">
                </div>
                <div class="about-hero-note">
                    <p class="text-sm uppercase tracking-[0.24em] text-cyan-200">Fresh promise</p>
                    <h2 class="mt-3 text-2xl font-semibold text-white">Premium cleaning solutions with a human touch.</h2>
                    <p class="mt-3 text-sm leading-7 text-slate-200">From product quality to delivery speed, everything is shaped to feel easy, trustworthy, and refreshingly modern.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="shell py-12">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="about-story-card reveal">
                <p class="about-section-kicker">Mission</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">Create cleaning products that simplify everyday life.</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">We focus on dependable formulas, clear product purpose, and easy shopping so customers can clean faster without guesswork.</p>
            </div>
            <div class="about-story-card reveal">
                <p class="about-section-kicker">Vision</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">Become the most trusted modern cleaning brand for daily routines.</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">SprayWow aims to combine freshness, functionality, and better design into a cleaning experience people actually enjoy using.</p>
            </div>
            <div class="about-story-card reveal">
                <p class="about-section-kicker">Our Story</p>
                <h2 class="mt-3 text-2xl font-semibold text-slate-950">Built for real homes, real routines, and real expectations.</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">We noticed that many household products either looked outdated or felt overly clinical. SprayWow was created to bring clean performance and clean design together.</p>
            </div>
        </div>
    </section>

    <section class="shell py-10">
        <div class="mb-8 reveal">
            <span class="eyebrow !border-sky-200 !bg-sky-100/80 !text-slate-700">Why Customers Trust Us</span>
            <h2 class="section-title">Strengths that keep SprayWow feeling fresh, reliable, and worth coming back to</h2>
        </div>
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($featureCards as $feature)
                <div class="about-feature-card reveal">
                    <div class="about-feature-icon">
                        @switch($feature['icon'])
                            @case('leaf')
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <path d="M6 13c0 4 2.7 7 6 7 5 0 8-5 8-14-9 0-14 3-14 8Z"></path>
                                    <path d="M6 20c0-6 4-10 10-12"></path>
                                </svg>
                                @break
                            @case('delivery')
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <path d="M3 7h11v8H3V7Z"></path>
                                    <path d="M14 10h3l3 3v2h-6v-5Z"></path>
                                    <circle cx="8" cy="18" r="1.5"></circle>
                                    <circle cx="18" cy="18" r="1.5"></circle>
                                </svg>
                                @break
                            @case('shield')
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <path d="M12 3 4 7v6c0 4.4 3.4 8.4 8 9 4.6-.6 8-4.6 8-9V7l-8-4Z"></path>
                                    <path d="m9.5 12 1.7 1.7 3.3-3.7"></path>
                                </svg>
                                @break
                            @default
                                <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                    <path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.8 1-6.1L3.2 9.4l6.1-.9L12 3Z"></path>
                                </svg>
                        @endswitch
                    </div>
                    <h3 class="mt-5 text-xl font-semibold text-slate-950">{{ $feature['title'] }}</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $feature['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="shell py-12">
        <div class="about-trust-banner reveal">
            <div>
                <span class="eyebrow">Trusted by growing households</span>
                <h2 class="text-balance text-3xl font-semibold text-white sm:text-4xl">Clean design, dependable performance, and customer-first service.</h2>
                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-200">SprayWow blends quality, innovation, and affordability so shoppers can feel confident every step of the way, from browsing to delivery.</p>
            </div>
            <div class="about-trust-quote">
                <p class="text-amber-300">★★★★★</p>
                <p class="mt-4 text-lg font-medium leading-8 text-white">“SprayWow made my cleaning routine feel less like a chore and more like a quick reset. The products work well and the brand feels genuinely trustworthy.”</p>
                <p class="mt-5 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-200">Riya M. · Verified Customer</p>
            </div>
        </div>
    </section>

    <section class="shell pb-20 pt-8">
        <div class="mb-8 reveal">
            <span class="eyebrow !border-sky-200 !bg-sky-100/80 !text-slate-700">Meet the Team</span>
            <h2 class="section-title">The people helping SprayWow stay thoughtful, fast, and customer-focused</h2>
        </div>
        <div class="grid gap-5 md:grid-cols-3">
            @foreach($teamCards as $member)
                <div class="about-team-card reveal">
                    <div class="about-team-avatar tone-{{ $member['tone'] }}">
                        {{ strtoupper(substr($member['name'], 0, 1)) }}
                    </div>
                    <h3 class="mt-5 text-xl font-semibold text-slate-950">{{ $member['name'] }}</h3>
                    <p class="mt-2 text-sm font-semibold uppercase tracking-[0.18em] text-sky-600">{{ $member['role'] }}</p>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $member['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    @include('storefront.partials.footer')
</body>
</html>
