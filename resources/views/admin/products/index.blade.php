@extends('admin.layout')

@section('title', 'Products')
@section('kicker', 'Catalog Management')
@section('heading', 'Products')

@section('header_actions')
    <a href="{{ route('admin.products.create') }}" class="btn-primary">New product</a>
@endsection

@section('content')
    <section class="dashboard-panel">
        <div class="dashboard-panel-head">
            <div>
                <p class="dashboard-section-kicker">Catalog List</p>
                <h2 class="dashboard-section-title">Manage products</h2>
            </div>
        </div>

        <div class="dashboard-table-wrap mt-6">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <p class="font-semibold text-slate-950">{{ $product->name }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $product->sku ?: 'No SKU' }}</p>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td><span class="inventory-pill">{{ $product->stock }}</span></td>
                            <td>
                                <div class="flex flex-wrap gap-3 text-sm font-semibold">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-sky-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
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

        <div class="mt-6">{{ $products->links() }}</div>
    </section>
@endsection
