@extends('admin.layout')

@section('title', $post->exists ? 'Edit Blog Post' : 'Create Blog Post')
@section('kicker', 'Content Editor')
@section('heading', $post->exists ? 'Edit Blog Post' : 'Create Blog Post')

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">Article Details</p>
                <h2 class="dashboard-section-title">Write content that supports search visibility</h2>
            </div>
            <a href="{{ route('admin.blog.posts.index') }}" class="dashboard-inline-link">Back to posts</a>
        </div>

        <form method="POST" action="{{ $post->exists ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if($post->exists)
                @method('PUT')
            @endif

            <select name="blog_category_id" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('blog_category_id', $post->blog_category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <input name="author_name" value="{{ old('author_name', $post->author_name ?: 'SprayWow Team') }}" placeholder="Author name" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <input name="title" value="{{ old('title', $post->title) }}" placeholder="Post title" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">
            <input name="slug" value="{{ old('slug', $post->slug) }}" placeholder="SEO slug" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">
            <input name="featured_image" value="{{ old('featured_image', $post->featured_image) }}" placeholder="Featured image URL" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">
            <textarea name="excerpt" rows="3" placeholder="Short excerpt" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">{{ old('excerpt', $post->excerpt) }}</textarea>
            <textarea name="content" rows="14" placeholder="HTML content editor" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">{{ old('content', $post->content) }}</textarea>
            <input name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" placeholder="Meta title" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <input name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}" placeholder="Keywords" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <textarea name="meta_description" rows="3" placeholder="Meta description" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">{{ old('meta_description', $post->meta_description) }}</textarea>
            <div class="rounded-[24px] border border-sky-100 bg-sky-50/70 p-4 md:col-span-2">
                <p class="text-sm font-semibold text-slate-950">Tags</p>
                <div class="mt-3 flex flex-wrap gap-3">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center gap-2 rounded-full border border-sky-100 bg-white px-3 py-2 text-sm text-slate-700">
                            <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tag_ids', $selectedTags), true))>
                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <label class="flex items-center gap-3 rounded-2xl border border-sky-100 bg-sky-50/70 px-4 py-3 text-slate-700">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published ?? true))>
                Publish article
            </label>

            <div class="md:col-span-2">
                <button class="btn-primary">{{ $post->exists ? 'Update Post' : 'Create Post' }}</button>
            </div>
        </form>
    </section>
@endsection
