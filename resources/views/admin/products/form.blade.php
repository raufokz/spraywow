@extends('admin.layout')

@section('title', $product->exists ? 'Edit Product' : 'New Product')
@section('kicker', 'Catalog Management')
@section('heading', $product->exists ? 'Edit Product' : 'New Product')

@section('header_actions')
    <a href="{{ route('admin.products.index') }}" class="btn-secondary !px-4 !py-2">All products</a>
@endsection

@section('content')
    @if($errors->any())
        <div class="dashboard-alert dashboard-alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="admin-product-page">
        <section class="dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <p class="dashboard-section-kicker">{{ $product->exists ? 'Edit Product' : 'New Product' }}</p>
                    <h2 class="dashboard-section-title">
                        {{ $product->exists ? 'Update product details and media' : 'Create a clean new product entry' }}
                    </h2>
                </div>
                <a href="{{ route('admin.products.index') }}" class="dashboard-inline-link">View all products</a>
            </div>

            <div class="mt-6">
                @include('admin.products._form-fields', ['product' => $product])
            </div>
        </section>

        <aside class="dashboard-panel admin-product-sidecard">
            <p class="dashboard-section-kicker">Publishing Notes</p>
            <h3 class="dashboard-section-title text-[1.55rem]">{{ $product->exists ? 'Editing checklist' : 'Before you save' }}</h3>
            <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                <p>Use a concise product name that matches how customers will see it in the catalog.</p>
                <p>Choose a clear product photo with a square or landscape crop so cards and previews stay neat across devices.</p>
                <p>The product link should be a complete URL and can point to the storefront page, marketplace page, or campaign landing page.</p>
            </div>
        </aside>
    </div>
@endsection
