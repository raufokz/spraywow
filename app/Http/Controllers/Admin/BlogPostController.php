<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.posts.index', [
            'posts' => BlogPost::query()->with('category')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.posts.form', [
            'post' => new BlogPost(['is_published' => true]),
            'categories' => BlogCategory::query()->orderBy('name')->get(),
            'tags' => BlogTag::query()->orderBy('name')->get(),
            'selectedTags' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $post = BlogPost::query()->create($validated);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.posts.index')->with('success', 'Blog post created.');
    }

    public function edit(BlogPost $post): View
    {
        return view('admin.blog.posts.form', [
            'post' => $post->load('tags'),
            'categories' => BlogCategory::query()->orderBy('name')->get(),
            'tags' => BlogTag::query()->orderBy('name')->get(),
            'selectedTags' => $post->tags->pluck('id')->all(),
        ]);
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $validated = $this->validated($request);
        $post->update($validated);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.posts.index')->with('success', 'Blog post updated.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $post->delete();

        return back()->with('success', 'Blog post removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'author_name' => ['required', 'string', 'max:255'],
            'featured_image' => ['nullable', 'string'],
            'excerpt' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]) + [
            'is_published' => $request->boolean('is_published', true),
        ];
    }
}
