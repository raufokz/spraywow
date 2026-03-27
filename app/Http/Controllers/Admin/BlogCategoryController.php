<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.categories.index', [
            'categories' => BlogCategory::query()->withCount('posts')->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.categories.form', ['category' => new BlogCategory()]);
    }

    public function store(Request $request): RedirectResponse
    {
        BlogCategory::query()->create($this->validated($request));

        return redirect()->route('admin.blog.categories.index')->with('success', 'Blog category created.');
    }

    public function edit(BlogCategory $category): View
    {
        return view('admin.blog.categories.form', compact('category'));
    }

    public function update(Request $request, BlogCategory $category): RedirectResponse
    {
        $category->update($this->validated($request));

        return redirect()->route('admin.blog.categories.index')->with('success', 'Blog category updated.');
    }

    public function destroy(BlogCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Blog category removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
