<form
    method="POST"
    action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
    enctype="multipart/form-data"
    class="admin-product-form"
>
    @csrf
    @if($product->exists)
        @method('PUT')
    @endif

    <div class="admin-form-field admin-form-field-full">
        <label for="name" class="admin-form-label">Product Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $product->name) }}"
            class="admin-form-input"
            placeholder="Enter product name"
            required
        >
        @error('name')
            <p class="admin-form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="admin-form-field admin-form-field-full">
        <label for="description" class="admin-form-label">Product Description</label>
        <textarea
            id="description"
            name="description"
            rows="7"
            class="admin-form-input admin-form-textarea"
            placeholder="Write a short product description"
            required
        >{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p class="admin-form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="admin-form-field">
        <label for="image" class="admin-form-label">Product Image</label>
        <input
            id="image"
            name="image"
            type="file"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
            class="admin-form-input admin-form-file"
            data-product-upload-input
        >
        <p class="admin-form-help">Optional. Accepted: JPG or PNG, up to 2MB.</p>
        @error('image')
            <p class="admin-form-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="admin-form-field admin-form-field-full">
        <div class="admin-image-preview-card">
            <div class="admin-image-preview-shell">
                <img
                    src="{{ old('existing_image_url', $product->image_url ?: 'https://placehold.co/640x420/e2e8f0/475569?text=Preview') }}"
                    alt="Product preview"
                    class="admin-image-preview"
                    data-product-upload-preview
                >
            </div>
            <div>
                <p class="font-semibold text-slate-950">Image preview</p>
                <p class="mt-2 text-sm leading-6 text-slate-500">The preview updates before submission so you can confirm the right product image is selected.</p>
            </div>
        </div>
        <input type="hidden" name="existing_image_url" value="{{ old('existing_image_url', $product->image_url) }}">
    </div>

    <div class="admin-form-actions admin-form-field-full">
        <button class="btn-primary w-full sm:w-auto">
            {{ $product->exists ? 'Save changes' : 'Save product' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn-secondary w-full justify-center sm:w-auto">Back to products</a>
    </div>
</form>
