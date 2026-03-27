@extends('admin.layout')

@section('title', 'Products')
@section('kicker', 'Catalog Management')
@section('heading', 'Products')

@section('header_actions')
    <a href="{{ route('admin.products.create') }}" class="btn-primary">New product</a>
@endsection

@section('content')
    @if(session('success'))
        <div class="dashboard-alert dashboard-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">Product Library</p>
                <h2 class="dashboard-section-title">Browse and manage every product</h2>
            </div>
            <div class="admin-products-toolbar">
                <span class="admin-products-count">{{ $products->total() }} products</span>
                <a href="{{ route('admin.products.create') }}" class="dashboard-inline-link">Create another</a>
            </div>
        </div>

        <div class="dashboard-table-wrap mt-6 hidden lg:block">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-products-thumb">
                            </td>
                            <td>
                                <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                            </td>
                            <td>
                                @if($product->product_link)
                                    <a href="{{ $product->product_link }}" target="_blank" rel="noreferrer" class="dashboard-inline-link break-all">
                                        {{ $product->product_link }}
                                    </a>
                                @else
                                    <span class="text-slate-400">No link</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-600">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-slate-500">No products found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-products-grid mt-6 lg:hidden">
            @forelse($products as $product)
                <article class="admin-product-card">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-product-card-image">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-950">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">{{ \Illuminate\Support\Str::limit($product->description, 110) }}</p>
                        @if($product->product_link)
                            <a href="{{ $product->product_link }}" target="_blank" rel="noreferrer" class="dashboard-inline-link mt-3 inline-flex break-all">
                                Open product link
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-3 text-sm font-semibold">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-sky-700">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-rose-600">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="admin-product-card text-center text-slate-500">
                    No products found yet.
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $products->links() }}</div>
    </section>
@endsection
