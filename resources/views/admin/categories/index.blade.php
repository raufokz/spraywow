@extends('admin.layout')

@section('title', 'Categories')
@section('kicker', 'Catalog Structure')
@section('heading', 'Categories')

@section('header_actions')
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">New category</a>
@endsection

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">Collection Groups</p>
                <h2 class="dashboard-section-title">Organize categories</h2>
            </div>
        </div>

        <div class="dashboard-table-wrap mt-6">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Accent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="font-semibold text-slate-950">{{ $category->name }}</td>
                            <td>{{ $category->products_count }}</td>
                            <td><span class="inline-block h-8 w-14 rounded-full" style="background: {{ $category->accent_color }}"></span></td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
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
