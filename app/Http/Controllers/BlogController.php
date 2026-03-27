<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = BlogPost::query()
            ->published()
            ->with(['category', 'tags'])
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($builder) => $builder->where('slug', $request->string('category')));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', fn ($builder) => $builder->where('slug', $request->string('tag')));
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('storefront.blog.index', [
            'posts' => $posts,
            'featuredPost' => BlogPost::query()->published()->with(['category', 'tags'])->latest('published_at')->first(),
            'categories' => BlogCategory::query()->withCount(['posts' => fn ($query) => $query->published()])->orderBy('name')->get(),
            'tags' => BlogTag::query()->withCount(['posts' => fn ($query) => $query->published()])->orderBy('name')->take(12)->get(),
            'recentPosts' => BlogPost::query()->published()->latest('published_at')->take(4)->get(),
            'activeCategory' => $request->string('category')->toString(),
            'activeTag' => $request->string('tag')->toString(),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published && (blank($post->published_at) || $post->published_at->lte(now())), 404);

        $post->load(['category', 'tags']);

        return view('storefront.blog.show', [
            'post' => $post,
            'recentPosts' => BlogPost::query()->published()->whereKeyNot($post->id)->latest('published_at')->take(4)->get(),
            'categories' => BlogCategory::query()->withCount(['posts' => fn ($query) => $query->published()])->orderBy('name')->get(),
            'tags' => BlogTag::query()->withCount(['posts' => fn ($query) => $query->published()])->orderBy('name')->take(12)->get(),
        ]);
    }
}
