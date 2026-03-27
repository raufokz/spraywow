<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.seo', [
        'title' => 'SprayWow Blog | Cleaning Tips, Product Guides, and Home Care Advice',
        'description' => 'Explore SprayWow blog articles on cleaning sprays, home cleaning tips, product guides, and smart ways to keep every room fresher.',
        'keywords' => 'SprayWow blog, cleaning tips, home care guides, cleaning spray articles',
        'canonical' => route('blog.index'),
        'type' => 'website',
    ])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <section class="shell hero-band pb-10 pt-8 sm:pb-14 sm:pt-10">
        <div class="blog-hero reveal">
            <div>
                <span class="eyebrow">SprayWow Journal</span>
                <h1 class="text-balance text-4xl font-semibold text-white sm:text-5xl">Cleaning tips, product guides, and fresher living ideas.</h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-200">Content built to help customers find smarter cleaning routines, better spray choices, and practical ways to care for every room.</p>
            </div>
            @if($featuredPost)
                <a href="{{ route('blog.show', $featuredPost) }}" class="blog-featured-card">
                    <div class="blog-featured-media">
                        <img src="{{ $featuredPost->featured_image ?: asset('images/spray-wow-logo-500.webp') }}" alt="{{ $featuredPost->title }}" class="blog-featured-image" loading="lazy">
                    </div>
                    <div class="blog-featured-copy">
                        <span class="blog-chip">{{ $featuredPost->category?->name ?: 'Featured' }}</span>
                        <h2 class="mt-3 text-2xl font-semibold text-white">{{ $featuredPost->title }}</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-200">{{ $featuredPost->excerpt }}</p>
                    </div>
                </a>
            @endif
        </div>
    </section>

    <section class="shell pb-20">
        <div class="grid gap-8 lg:grid-cols-[1fr_.33fr]">
            <div>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($posts as $post)
                        <article class="blog-card reveal">
                            <a href="{{ route('blog.show', $post) }}">
                                <div class="blog-card-media">
                                    <img src="{{ $post->featured_image ?: asset('images/spray-wow-logo-500.webp') }}" alt="{{ $post->title }}" class="blog-card-image" loading="lazy">
                                </div>
                            </a>
                            <div class="mt-4 flex items-center gap-3 text-xs uppercase tracking-[0.18em] text-sky-600">
                                <span>{{ $post->category?->name ?: 'Blog' }}</span>
                                <span>{{ optional($post->published_at)->format('M d, Y') }}</span>
                            </div>
                            <a href="{{ route('blog.show', $post) }}">
                                <h2 class="mt-3 text-xl font-semibold text-slate-950">{{ $post->title }}</h2>
                            </a>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $post->excerpt }}</p>
                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-sm text-slate-500">{{ $post->reading_time }} min read</span>
                                <a href="{{ route('blog.show', $post) }}" class="text-sm font-semibold text-sky-700">Read More</a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-8">{{ $posts->links() }}</div>
            </div>

            <aside class="space-y-6">
                <div class="blog-sidebar-card">
                    <h3 class="text-lg font-semibold text-slate-950">Recent Posts</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($recentPosts as $post)
                            <a href="{{ route('blog.show', $post) }}" class="block rounded-[20px] border border-sky-100 bg-sky-50/60 p-4">
                                <p class="font-semibold text-slate-950">{{ $post->title }}</p>
                                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-400">{{ optional($post->published_at)->format('M d, Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="blog-sidebar-card">
                    <h3 class="text-lg font-semibold text-slate-950">Categories</h3>
                    <div class="mt-4 flex flex-col gap-3">
                        @foreach($categories as $category)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="blog-filter-link {{ $activeCategory === $category->slug ? 'is-active' : '' }}">
                                <span>{{ $category->name }}</span>
                                <span>{{ $category->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="blog-sidebar-card">
                    <h3 class="text-lg font-semibold text-slate-950">Tags</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="blog-tag-chip {{ $activeTag === $tag->slug ? 'is-active' : '' }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>

    @include('storefront.partials.footer')
</body>
</html>
