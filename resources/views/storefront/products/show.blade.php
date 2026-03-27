@php
    $galleryImages = collect([$product->image_url])
        ->merge($product->gallery ?? [])
        ->filter()
        ->unique()
        ->values();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.seo', [
        'title' => $product->meta_title ?: $product->name.' | SprayWow',
        'description' => $product->meta_description ?: $product->short_description,
        'keywords' => $product->category->name.', cleaning spray, SprayWow',
        'canonical' => route('products.show', $product),
        'image' => $product->image_url,
        'type' => 'product',
    ])
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => $galleryImages->all(),
            'description' => $product->meta_description ?: $product->short_description,
            'sku' => $product->sku,
            'brand' => ['@type' => 'Brand', 'name' => 'SprayWow'],
            'offers' => [
                '@type' => 'Offer',
                'priceCurrency' => 'USD',
                'price' => (string) $product->price,
                'availability' => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url' => route('products.show', $product),
            ],
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <div class="shell py-8">
        <a href="{{ route('products.index') }}" class="text-sm text-cyan-200">Back to catalog</a>

        <div class="product-show-layout mt-6">
            <div class="glass-panel p-5 sm:p-6">
                <div class="product-gallery" data-product-gallery>
                    <div class="product-zoom-frame skeleton" data-image-shell data-product-zoom>
                        <img
                            src="{{ $galleryImages->first() }}"
                            alt="{{ $product->name }}"
                            class="product-zoom-image"
                            data-product-main-image
                        >
                    </div>

                    <div class="product-thumb-grid">
                        @foreach($galleryImages as $index => $image)
                            <button
                                type="button"
                                class="product-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                data-product-thumb
                                data-image-src="{{ $image }}"
                                aria-label="Show product image {{ $index + 1 }}"
                            >
                                <img src="{{ $image }}" alt="{{ $product->name }}" class="h-full w-full rounded-[18px] object-contain bg-sky-50 p-3">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="glass-panel p-7 sm:p-8">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-sky-600">{{ $product->category->name }}</p>
                <h1 class="mt-2 text-balance text-4xl font-semibold text-slate-950">{{ $product->name }}</h1>
                <p class="mt-3 text-lg text-slate-600">{{ $product->tagline }}</p>

                <div class="mt-5 flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl font-semibold text-slate-950">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="text-lg text-slate-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                        @endif
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</span>
                </div>

                <div class="product-rating-row mt-5">
                    <span class="product-stars">{{ str_repeat('★', max(1, (int) round($product->reviews_avg_rating ?: 5))) }}</span>
                    <span class="text-sm text-slate-500">{{ number_format($product->reviews_avg_rating ?: 5, 1) }} average · {{ $product->reviews_count }} reviews</span>
                </div>

                <p class="mt-6 leading-7 text-slate-600">{{ $product->description }}</p>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    @foreach(($product->benefits ?? []) as $benefit)
                        <div class="rounded-[20px] border border-sky-100 bg-sky-50/70 px-4 py-3 text-sm font-medium text-slate-700">{{ $benefit }}</div>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center">
                    @csrf
                    <div class="quantity-selector">
                        <label for="quantity" class="sr-only">Quantity</label>
                        <input id="quantity" type="number" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-24 border-0 bg-transparent text-center text-base font-semibold text-slate-900 outline-none">
                    </div>
                    <button class="btn-primary min-w-[13rem]">Add to Cart</button>
                </form>

                <div class="mt-8 grid gap-3 sm:grid-cols-3">
                    <div class="mini-info-card">Safe on most surfaces</div>
                    <div class="mini-info-card">Fresh scent finish</div>
                    <div class="mini-info-card">Responsive customer support</div>
                </div>
            </div>
        </div>

        <div class="mt-10 glass-panel p-6 sm:p-8">
            <div class="product-tabs" data-product-tabs>
                <div class="product-tab-list">
                    <button type="button" class="product-tab-button is-active" data-tab-trigger="description">Description</button>
                    <button type="button" class="product-tab-button" data-tab-trigger="reviews">Reviews</button>
                    <button type="button" class="product-tab-button" data-tab-trigger="details">Additional Info</button>
                </div>

                <div class="mt-6" data-tab-panel="description">
                    <div class="max-w-3xl text-sm leading-8 text-slate-600">
                        <p>{{ $product->description }}</p>
                        <p class="mt-4">{{ $product->short_description }}</p>
                    </div>
                </div>

                <div class="mt-6 hidden" data-tab-panel="reviews">
                    <div class="space-y-4">
                        @forelse($product->reviews as $review)
                            <div class="rounded-[24px] border border-sky-100 bg-white p-5 shadow-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-950">{{ $review->title }}</p>
                                        <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">{{ $review->user->name }}</p>
                                    </div>
                                    <span class="product-stars">{{ str_repeat('★', $review->rating) }}</span>
                                </div>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No reviews yet.</p>
                        @endforelse
                    </div>

                    @auth
                        <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="mt-6 grid gap-3 sm:grid-cols-2">
                            @csrf
                            <select name="rating" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 sm:col-span-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} stars</option>
                                @endfor
                            </select>
                            <input type="text" name="title" placeholder="Review title" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 sm:col-span-1">
                            <textarea name="comment" rows="4" placeholder="Share your experience" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 sm:col-span-2"></textarea>
                            <button class="btn-secondary sm:col-span-2 sm:w-fit">Submit review</button>
                        </form>
                    @endauth
                </div>

                <div class="mt-6 hidden" data-tab-panel="details">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="mini-info-card">Category: {{ $product->category->name }}</div>
                        <div class="mini-info-card">SKU: {{ $product->sku ?: 'SprayWow standard' }}</div>
                        <div class="mini-info-card">Stock available: {{ $product->stock }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="section-title text-white">You may also like</h2>
            <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($relatedProducts as $related)
                    <div class="product-card">
                        <a href="{{ route('products.show', $related) }}" class="block">
                            <div class="product-media skeleton" data-image-shell>
                                <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="product-card-image">
                            </div>
                        </a>
                        <a href="{{ route('products.show', $related) }}" class="block">
                            <h3 class="product-card-title">{{ $related->name }}</h3>
                        </a>
                        <div class="product-rating-row">
                            <span class="product-stars">{{ str_repeat('★', max(1, (int) round($related->reviews_avg_rating ?: 5))) }}</span>
                            <span class="text-sm text-slate-500">{{ number_format($related->reviews_avg_rating ?: 5, 1) }} · {{ $related->reviews_count }} reviews</span>
                        </div>
                        <p class="product-card-copy">{{ $related->tagline }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('storefront.partials.footer')
</body>
</html>
