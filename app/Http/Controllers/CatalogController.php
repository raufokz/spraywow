<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->string('sort')->toString();

        $products = Product::query()
            ->active()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->search($request->string('q')->toString())
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($builder) => $builder->where('slug', $request->string('category')));
            });

        match ($sort) {
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            'name' => $products->orderBy('name'),
            default => $products->latest(),
        };

        return view('storefront.products.index', [
            'products' => $products->paginate(12)->withQueryString(),
            'categories' => Category::query()->orderBy('name')->get(),
            'activeCategory' => $request->string('category')->toString(),
            'sort' => $sort,
            'search' => $request->string('q')->toString(),
        ]);
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'reviews.user'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        return view('storefront.products.show', [
            'product' => $product,
            'relatedProducts' => Product::query()
                ->active()
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->take(4)
                ->get(),
        ]);
    }
}
