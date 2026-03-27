@extends('admin.layout')

@section('title', 'Blog Categories')
@section('kicker', 'Content Taxonomy')
@section('heading', 'Blog Categories')

@section('header_actions')
    <a href="{{ route('admin.blog.posts.index') }}" class="btn-secondary !px-4 !py-2">Posts</a>
    <a href="{{ route('admin.blog.categories.create') }}" class="btn-primary">New category</a>
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
                    @foreach($categories as $category)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.blog.categories.edit', $category) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.blog.categories.destroy', $category) }}">
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
        <div class="mt-6">{{ $categories->links() }}</div>
    </section>
@endsection
