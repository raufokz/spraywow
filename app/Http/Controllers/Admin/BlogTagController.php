<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogTagController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.tags.index', [
            'tags' => BlogTag::query()->withCount('posts')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.tags.form', ['tag' => new BlogTag()]);
    }

    public function store(Request $request): RedirectResponse
    {
        BlogTag::query()->create($this->validated($request));

        return redirect()->route('admin.blog.tags.index')->with('success', 'Blog tag created.');
    }

    public function edit(BlogTag $tag): View
    {
        return view('admin.blog.tags.form', compact('tag'));
    }

    public function update(Request $request, BlogTag $tag): RedirectResponse
    {
        $tag->update($this->validated($request));

        return redirect()->route('admin.blog.tags.index')->with('success', 'Blog tag updated.');
    }

    public function destroy(BlogTag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('success', 'Blog tag removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
