@extends('admin.layout')

@section('title', 'Blog Tags')
@section('kicker', 'Content Taxonomy')
@section('heading', 'Blog Tags')

@section('header_actions')
    <a href="{{ route('admin.blog.posts.index') }}" class="btn-secondary !px-4 !py-2">Posts</a>
    <a href="{{ route('admin.blog.tags.create') }}" class="btn-primary">New tag</a>
@endsection

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-table-wrap">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $tag->name }}</td>
                            <td>{{ $tag->slug }}</td>
                            <td>{{ $tag->posts_count }}</td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.blog.tags.edit', $tag) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.blog.tags.destroy', $tag) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $tags->links() }}</div>
    </section>
@endsection
