@extends('admin.layout')

@section('title', $category->exists ? 'Edit Blog Category' : 'Create Blog Category')
@section('kicker', 'Content Taxonomy')
@section('heading', $category->exists ? 'Edit Blog Category' : 'Create Blog Category')

@section('content')
    <section class="dashboard-panel">
        <form method="POST" action="{{ $category->exists ? route('admin.blog.categories.update', $category) : route('admin.blog.categories.store') }}" class="grid gap-4 md:grid-cols-2">
            @csrf
            @if($category->exists)
                @method('PUT')
            @endif
            <input name="name" value="{{ old('name', $category->name) }}" placeholder="Category name" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <input name="slug" value="{{ old('slug', $category->slug) }}" placeholder="Slug" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <textarea name="description" rows="4" placeholder="Description" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900 md:col-span-2">{{ old('description', $category->description) }}</textarea>
            <div class="md:col-span-2">
                <button class="btn-primary">{{ $category->exists ? 'Update Category' : 'Create Category' }}</button>
            </div>
        </form>
    </section>
@endsection
