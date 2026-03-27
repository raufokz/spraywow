<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['required', 'string', 'max:120'],
            'comment' => ['required', 'string', 'max:1500'],
        ]);

        $product->reviews()->updateOrCreate(['user_id' => $request->user()->id], $validated);

        return back()->with('success', 'Thanks for sharing your review.');
    }
}
