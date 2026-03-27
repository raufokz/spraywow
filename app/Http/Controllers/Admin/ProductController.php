<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->with('category')->latest()->paginate(12)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product([
                'name' => old('name'),
                'description' => old('description'),
                'product_link' => old('product_link'),
                'image_url' => old('existing_image_url'),
            ]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create($this->validated($request));

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validated($request, $product));

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteStoredImage($product->image_url);
        $product->delete();

        return back()->with('success', 'Product removed.');
    }

    protected function validated(Request $request, ?Product $product = null): array
    {
        $product ??= $request->route('product');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'product_link' => ['required', 'url', 'max:2048'],
            'image' => [$product?->exists ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $categoryId = Category::query()->value('id');

        if (! $categoryId) {
            throw ValidationException::withMessages([
                'name' => 'Create at least one category before adding products.',
            ]);
        }

        $description = trim($validated['description']);
        $name = trim($validated['name']);
        $shortDescription = Str::limit(strip_tags($description), 255);

        $validated['category_id'] = $product?->category_id ?? $categoryId;
        $validated['slug'] = $this->uniqueSlug($name, $product);
        $validated['sku'] = $product?->sku ?: $this->generateSku($name);
        $validated['tagline'] = Str::limit($shortDescription ?: $name, 255);
        $validated['short_description'] = $shortDescription ?: $name;
        $validated['price'] = $product?->price ?? 0;
        $validated['compare_price'] = $product?->compare_price;
        $validated['gallery'] = $product?->gallery ?? [];
        $validated['benefits'] = $product?->benefits ?? [];
        $validated['stock'] = $product?->stock ?? 0;
        $validated['meta_title'] = $product?->meta_title ?: Str::limit($name.' | SprayWow', 255);
        $validated['meta_description'] = $product?->meta_description ?: Str::limit($shortDescription ?: $name, 255);
        $validated['is_featured'] = $product?->is_featured ?? false;
        $validated['is_active'] = $product?->is_active ?? true;

        if ($request->hasFile('image')) {
            $validated['image_url'] = Storage::disk('public')->url(
                $request->file('image')->store('products', 'public')
            );

            if ($product?->exists) {
                $this->deleteStoredImage($product->image_url);
            }
        } elseif ($product?->exists) {
            $validated['image_url'] = $product->image_url;
        }

        unset($validated['image']);

        return $validated;
    }

    protected function uniqueSlug(string $name, ?Product $product = null): string
    {
        $baseSlug = Str::slug($name) ?: 'product';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Product::query()
                ->when($product?->exists, fn ($query) => $query->whereKeyNot($product->getKey()))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    protected function generateSku(string $name): string
    {
        $prefix = Str::upper(Str::substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 3) ?: 'SW');

        do {
            $sku = $prefix.'-'.Str::upper(Str::random(6));
        } while (Product::query()->where('sku', $sku)->exists());

        return $sku;
    }

    protected function deleteStoredImage(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }

        $publicStorageUrl = Storage::disk('public')->url('');

        if (! str_starts_with($imageUrl, $publicStorageUrl)) {
            return;
        }

        $path = ltrim(Str::after($imageUrl, $publicStorageUrl), '/');

        if ($path !== '') {
            Storage::disk('public')->delete($path);
        }
    }
}
