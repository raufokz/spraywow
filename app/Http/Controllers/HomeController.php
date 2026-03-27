<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredProducts = Product::query()
            ->active()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_featured', true)
            ->take(8)
            ->get();

        return view('storefront.home', [
            'featuredProducts' => $featuredProducts,
            'heroSlides' => $featuredProducts->take(3)->values(),
            'bestSellers' => $featuredProducts->take(4),
            'categories' => Category::query()->withCount('products')->take(6)->get(),
            'testimonials' => Review::query()->with(['user', 'product'])->latest()->take(3)->get(),
            'trustBadges' => ['Dermatologist-safe formulas', 'Free shipping over $75', 'Fast U.S. dispatch', '30-day freshness guarantee'],
        ]);
    }
}
