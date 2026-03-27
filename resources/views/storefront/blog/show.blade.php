<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.seo', [
        'title' => $post->meta_title ?: $post->title.' | SprayWow Blog',
        'description' => $post->meta_description ?: $post->excerpt,
        'keywords' => $post->meta_keywords ?: $post->tags->pluck('name')->implode(', '),
        'canonical' => route('blog.show', $post),
        'image' => $post->featured_image ?: asset('images/spray-wow-logo-500.webp'),
        'type' => 'article',
    ])
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->meta_description ?: $post->excerpt,
            'image' => [$post->featured_image ?: asset('images/spray-wow-logo-500.webp')],
            'author' => ['@type' => 'Person', 'name' => $post->author_name],
            'publisher' => ['@type' => 'Organization', 'name' => 'SprayWow', 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/spray-wow-logo-500.webp')]],
            'datePublished' => optional($post->published_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'mainEntityOfPage' => route('blog.show', $post),
        ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('storefront.partials.header')

    <div class="shell py-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_.34fr]">
            <article class="glass-panel overflow-hidden p-0">
                <div class="blog-post-hero-media">
                    <img src="{{ $post->featured_image ?: asset('images/spray-wow-logo-500.webp') }}" alt="{{ $post->title }}" class="blog-post-hero-image" loading="lazy">
                </div>
                <div class="p-6 sm:p-8">
                    <div class="flex flex-wrap items-center gap-3 text-xs uppercase tracking-[0.18em] text-sky-600">
                        <span>{{ $post->category?->name ?: 'Blog' }}</span>
                        <span>{{ optional($post->published_at)->format('M d, Y') }}</span>
                        <span>{{ $post->reading_time }} min read</span>
                    </div>
                    <h1 class="mt-4 text-balance text-4xl font-semibold text-slate-950 sm:text-5xl">{{ $post->title }}</h1>
                    <p class="mt-4 text-base leading-8 text-slate-600">{{ $post->excerpt }}</p>
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-4 border-b border-sky-100 pb-6">
                        <p class="text-sm font-semibold text-slate-700">By {{ $post->author_name }}</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post)) }}" target="_blank" class="blog-tag-chip">Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="blog-tag-chip">Twitter</a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post)) }}" target="_blank" class="blog-tag-chip">LinkedIn</a>
                        </div>
                    </div>
                    <div class="blog-content mt-8">
                        {!! $post->content !!}
                    </div>
                </div>
            </article>

            <aside class="space-y-6">
                <div class="blog-sidebar-card">
                    <h3 class="text-lg font-semibold text-slate-950">Recent Posts</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($recentPosts as $recentPost)
                            <a href="{{ route('blog.show', $recentPost) }}" class="block rounded-[20px] border border-sky-100 bg-sky-50/60 p-4">
                                <p class="font-semibold text-slate-950">{{ $recentPost->title }}</p>
                                <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-400">{{ optional($recentPost->published_at)->format('M d, Y') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="blog-sidebar-card">
                    <h3 class="text-lg font-semibold text-slate-950">Categories</h3>
                    <div class="mt-4 flex flex-col gap-3">
                        @foreach($categories as $category)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="blog-filter-link">
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
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="blog-tag-chip">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @include('storefront.partials.footer')
</body>
</html>
