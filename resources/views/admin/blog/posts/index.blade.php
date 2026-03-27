@extends('admin.layout')

@section('title', 'Blog Posts')
@section('kicker', 'Content Marketing')
@section('heading', 'Blog Posts')

@section('header_actions')
    <a href="{{ route('admin.blog.categories.index') }}" class="btn-secondary !px-4 !py-2">Categories</a>
    <a href="{{ route('admin.blog.tags.index') }}" class="btn-secondary !px-4 !py-2">Tags</a>
    <a href="{{ route('admin.blog.posts.create') }}" class="btn-primary">New post</a>
@endsection

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">SEO Content</p>
                <h2 class="dashboard-section-title">Manage blog articles</h2>
            </div>
        </div>
        <div class="dashboard-table-wrap mt-6">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Post</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                <p class="font-semibold text-slate-950">{{ $post->title }}</p>
                                <p class="mt-1 text-xs text-slate-400">/{{ $post->slug }}</p>
                            </td>
                            <td>{{ $post->category?->name ?: 'Uncategorized' }}</td>
                            <td>{{ $post->author_name }}</td>
                            <td><span class="dashboard-status-badge {{ $post->is_published ? 'status-delivered' : 'status-pending' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td>{{ optional($post->published_at)->format('M d, Y') ?: 'Not set' }}</td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.blog.posts.edit', $post) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.blog.posts.destroy', $post) }}">
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
        <div class="mt-6">{{ $posts->links() }}</div>
    </section>
@endsection
