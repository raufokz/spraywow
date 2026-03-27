<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo', [
        'title' => 'SprayWow | Premium Cleaning Sprays',
        'description' => 'Premium cleaning sprays for shoes, kitchens, glass, cars, fabrics, tile, and more.',
        'keywords' => 'cleaning sprays, shoe cleaner, glass cleaner, kitchen cleaner, SprayWow',
        'canonical' => route('home'),
        'type' => 'website',
    ])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <section class="shell hero-band pb-10 pt-8 sm:pb-14 sm:pt-10">
        <div class="home-hero reveal">
            <div class="home-hero-slider" data-home-slider>
                @foreach($heroSlides as $index => $slide)
                    <article class="home-hero-slide {{ $index === 0 ? 'is-active' : '' }}" data-slide>
                        <div class="home-hero-copy">
                            <span class="eyebrow">Premium cleaning rituals</span>
                            <h1 class="text-balance text-4xl font-semibold text-white sm:text-5xl xl:text-6xl">
                                {{ $slide->name }}
                            </h1>
                            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                                {{ $slide->tagline ?: $slide->short_description }}
                            </p>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ route('products.show', $slide) }}" class="btn-primary">Shop Now</a>
                                <a href="{{ route('products.index') }}" class="btn-secondary">Explore Products</a>
                            </div>
                            <div class="mt-8 flex flex-wrap gap-3 text-sm text-white/90">
                                <span class="home-pill">High-shine finish</span>
                                <span class="home-pill">Fast-drying formula</span>
                                <span class="home-pill">Designed for daily use</span>
                            </div>
                        </div>
                        <div class="home-hero-visual">
                            <div class="home-hero-badge">
                                <span class="text-xs uppercase tracking-[0.24em] text-cyan-200">Featured spray</span>
                                <span class="mt-2 block text-2xl font-semibold text-white">${{ number_format($slide->price, 2) }}</span>
                                <span class="mt-1 block text-sm text-slate-200">{{ $slide->category->name }}</span>
                            </div>
                            <div class="home-hero-image-wrap skeleton" data-image-shell>
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->name }}" class="home-hero-image">
                            </div>
                            <div class="home-hero-floating-card">
                                <p class="text-sm font-semibold text-slate-950">Customer favorite</p>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $slide->short_description }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                <div class="flex gap-2">
                    @foreach($heroSlides as $index => $slide)
                        <button
                            type="button"
                            class="home-slider-dot {{ $index === 0 ? 'is-active' : '' }}"
                            data-slide-dot
                            data-slide-index="{{ $index }}"
                            aria-label="Go to slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
                <div class="grid gap-3 sm:grid-cols-3">
                    <div class="home-stat-card">
                        <p class="text-2xl font-semibold text-white">{{ $featuredProducts->count() }}+</p>
                        <p class="mt-1 text-sm text-slate-300">Premium catalog products</p>
                    </div>
                    <div class="home-stat-card">
                        <p class="text-2xl font-semibold text-white">4.9/5</p>
                        <p class="mt-1 text-sm text-slate-300">Average customer impression</p>
                    </div>
                    <div class="home-stat-card">
                        <p class="text-2xl font-semibold text-white">24h</p>
                        <p class="mt-1 text-sm text-slate-300">Fast dispatch turnaround</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shell pb-10">
        <div class="grid gap-4 rounded-[32px] bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.08)] md:grid-cols-4">
            @foreach($trustBadges as $badge)
                <div class="rounded-[22px] border border-sky-100 bg-sky-50/60 px-4 py-5 text-center text-sm font-medium text-slate-700">{{ $badge }}</div>
            @endforeach
        </div>
    </section>

    <section class="shell py-10">
        <div class="flex items-end justify-between gap-6">
            <div class="reveal">
                <span class="eyebrow !border-sky-200 !bg-sky-100/80 !text-slate-700">Featured Categories</span>
                <h2 class="section-title">Targeted formulas for every room, fabric, and finish</h2>
            </div>
            <a href="{{ route('products.index') }}" class="hidden text-sm font-semibold text-sky-700 md:block">Browse catalog</a>
        </div>
        <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="home-category-card reveal">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-semibold text-slate-950">{{ $category->name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $category->description }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold text-white" style="background: {{ $category->accent_color }}">{{ $category->products_count }} items</span>
                    </div>
                    <p class="mt-6 text-sm font-semibold text-sky-700">{{ $category->hero_copy }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="shell py-14">
        <div class="mb-8 reveal">
            <span class="eyebrow !border-sky-200 !bg-sky-100/80 !text-slate-700">Best Sellers</span>
            <h2 class="section-title">Top-performing sprays with elevated packaging and fast results</h2>
        </div>
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach($bestSellers as $product)
                <div class="product-card reveal">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="product-media skeleton" data-image-shell>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-card-image">
                        </div>
                    </a>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="product-badge">{{ $product->category->name }}</span>
                        <span class="product-card-stock">{{ $product->stock > 0 ? 'In stock' : 'Sold out' }}</span>
                    </div>
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <h3 class="product-card-title">{{ $product->name }}</h3>
                    </a>
                    <div class="product-rating-row">
                        <span class="product-stars">{{ str_repeat('★', max(1, (int) round($product->reviews_avg_rating ?: 5))) }}</span>
                        <span class="text-sm text-slate-500">{{ number_format($product->reviews_avg_rating ?: 5, 1) }} · {{ $product->reviews_count }} reviews</span>
                    </div>
                    <p class="product-card-copy">{{ $product->short_description }}</p>
                    <div class="product-card-footer">
                        <div>
                            <span class="text-lg font-semibold text-slate-950">${{ number_format($product->price, 2) }}</span>
                            @if($product->compare_price)
                                <span class="ml-2 text-sm text-slate-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('cart.store', $product) }}">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="product-card-button">Add to Cart</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="shell pb-16">
        <div class="home-banner reveal">
            <div>
                <span class="eyebrow">Fresh arrivals</span>
                <h2 class="text-balance text-3xl font-semibold text-white sm:text-4xl">From glass care to shoe rescue, keep the full SprayWow shelf within reach.</h2>
                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-200">Explore a tighter, cleaner catalog experience with high-performing sprays for kitchens, cars, fabrics, tiles, rust, and more.</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn-secondary">View Entire Collection</a>
        </div>
    </section>

    <section class="shell pb-20">
        <div class="glass-panel reveal p-8 sm:p-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <span class="eyebrow !border-sky-200 !bg-sky-100/80 !text-slate-700">Testimonials</span>
                    <h2 class="section-title">What customers notice first</h2>
                    <p class="mt-4 max-w-2xl text-slate-600">Real reviews build trust fast, so the section now feels lighter, cleaner, and more premium while keeping the human voice front and center.</p>
                </div>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach($testimonials as $review)
                    <div class="testimonial-card">
                        <div class="flex items-center gap-4">
                            <div class="testimonial-avatar">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                            <div>
                                <p class="font-semibold text-slate-950">{{ $review->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $review->product->name }}</p>
                            </div>
                        </div>
                        <p class="mt-5 text-amber-400">{{ str_repeat('★', $review->rating) }}</p>
                        <h3 class="mt-3 text-lg font-semibold text-slate-950">{{ $review->title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('storefront.partials.footer')
</body>
</html>
