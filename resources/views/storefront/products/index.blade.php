<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.seo', [
        'title' => 'Shop SprayWow | Premium Cleaning Products',
        'description' => 'Browse SprayWow cleaning sprays with filtering, search, and modern product discovery across every cleaning need.',
        'keywords' => 'buy cleaning sprays, spraywow products, home cleaning products',
        'canonical' => route('products.index'),
        'type' => 'website',
    ])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <div class="shell py-8 text-white">
        <div class="catalog-hero reveal">
            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.28em] text-sky-200">SprayWow Catalog</p>
                    <h1 class="mt-2 text-balance text-4xl font-semibold text-white sm:text-5xl">Find the right spray for every mess, room, and routine.</h1>
                    <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-200">Every card is now cleaner, roomier, and easier to scan, with full product visibility and a stronger add-to-cart experience.</p>
                </div>
                <div class="rounded-full bg-white/10 px-4 py-2 text-sm text-cyan-100">
                    {{ $products->total() }} products available
                </div>
            </div>

            <div class="glass-panel p-6">
                <form class="grid gap-4 md:grid-cols-[1.5fr_1fr_1fr_auto]">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search by product name or SKU" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                    <select name="category" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected($activeCategory === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="sort" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <option value="">Newest</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to high</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>Price: High to low</option>
                        <option value="name" @selected($sort === 'name')>Name</option>
                    </select>
                    <button class="btn-primary">Filter</button>
                </form>
            </div>
        </div>

        <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @forelse($products as $product)
                <div class="product-card reveal">
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="product-media skeleton" data-image-shell>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-card-image">
                        </div>
                    </a>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="product-badge">{{ $product->category->name }}</span>
                        <span class="product-card-stock">{{ $product->stock }} in stock</span>
                    </div>
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <h2 class="product-card-title">{{ $product->name }}</h2>
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
            @empty
                <div class="glass-panel col-span-full p-10 text-center text-slate-600">No products matched this filter.</div>
            @endforelse
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </div>

    @include('storefront.partials.footer')
</body>
</html>
