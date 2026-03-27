@extends('admin.layout')

@section('title', $tag->exists ? 'Edit Blog Tag' : 'Create Blog Tag')
@section('kicker', 'Content Taxonomy')
@section('heading', $tag->exists ? 'Edit Blog Tag' : 'Create Blog Tag')

@section('content')
    <section class="dashboard-panel">
        <form method="POST" action="{{ $tag->exists ? route('admin.blog.tags.update', $tag) : route('admin.blog.tags.store') }}" class="grid gap-4 md:grid-cols-2">
            @csrf
            @if($tag->exists)
                @method('PUT')
            @endif
            <input name="name" value="{{ old('name', $tag->name) }}" placeholder="Tag name" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <input name="slug" value="{{ old('slug', $tag->slug) }}" placeholder="Slug" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
            <div class="md:col-span-2">
                <button class="btn-primary">{{ $tag->exists ? 'Update Tag' : 'Create Tag' }}</button>
            </div>
        </form>
    </section>
@endsection
