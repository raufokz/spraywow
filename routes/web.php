<?php

use App\Http\Controllers\AccountOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\BlogTagController as AdminBlogTagController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/about', 'storefront.about', [
    'featureCards' => [
        ['title' => 'Eco-Friendly Products', 'copy' => 'Thoughtful formulas and packaging choices designed to feel cleaner, fresher, and more responsible.', 'icon' => 'leaf'],
        ['title' => 'Fast Delivery', 'copy' => 'Quick dispatch and smooth delivery so everyday cleaning essentials arrive when you need them.', 'icon' => 'delivery'],
        ['title' => 'Trusted Quality', 'copy' => 'Reliable performance across glass, kitchens, fabrics, shoes, and multi-surface care routines.', 'icon' => 'shield'],
        ['title' => 'Affordable Pricing', 'copy' => 'Premium-looking care products priced to work for real households and repeat buyers.', 'icon' => 'spark'],
    ],
    'teamCards' => [
        ['name' => 'Ayesha Khan', 'role' => 'Brand & Product Lead', 'copy' => 'Shapes product standards, packaging clarity, and the fresh SprayWow customer experience.', 'tone' => 'sky'],
        ['name' => 'Daniel Brooks', 'role' => 'Operations Manager', 'copy' => 'Keeps fulfillment fast, organized, and dependable from warehouse to doorstep.', 'tone' => 'amber'],
        ['name' => 'Mira Patel', 'role' => 'Customer Care Lead', 'copy' => 'Turns support into a warm, human experience that helps customers feel confident and cared for.', 'tone' => 'cyan'],
    ],
])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/products', [CatalogController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [CatalogController::class, 'show'])->name('products.show');
Route::get('/robots.txt', function (): Response {
    $content = "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n";

    return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
});
Route::get('/sitemap.xml', function (): Response {
    $items = collect([
        ['loc' => url('/'), 'lastmod' => now()->toDateString()],
        ['loc' => route('about'), 'lastmod' => now()->toDateString()],
        ['loc' => route('blog.index'), 'lastmod' => now()->toDateString()],
        ['loc' => route('products.index'), 'lastmod' => now()->toDateString()],
    ])
        ->merge(Product::query()->active()->get()->map(fn (Product $product) => [
            'loc' => route('products.show', $product),
            'lastmod' => optional($product->updated_at)->toDateString() ?? now()->toDateString(),
        ]))
        ->merge(BlogPost::query()->published()->get()->map(fn (BlogPost $post) => [
            'loc' => route('blog.show', $post),
            'lastmod' => optional($post->updated_at)->toDateString() ?? now()->toDateString(),
        ]));

    $xml = view('seo.sitemap', ['items' => $items]);

    return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
})->name('sitemap');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.store');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.destroy');

Route::middleware('auth')->group(function (): void {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/stripe/success/{order}', [CheckoutController::class, 'stripeSuccess'])->name('checkout.stripe.success');
    Route::get('/checkout/stripe/cancel/{order}', [CheckoutController::class, 'stripeCancel'])->name('checkout.stripe.cancel');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');

    Route::get('/dashboard', fn () => redirect()->route('account.orders.index'))->name('dashboard');
    Route::get('/account/orders', [AccountOrderController::class, 'index'])->name('account.orders.index');
    Route::get('/account/orders/{order}', [AccountOrderController::class, 'show'])->name('account.orders.show');
    Route::get('/account/orders/{order}/invoice', [AccountOrderController::class, 'invoice'])->name('account.orders.invoice');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('blog/posts', AdminBlogPostController::class)->names('blog.posts')->parameters(['posts' => 'post'])->except('show');
    Route::resource('blog/categories', AdminBlogCategoryController::class)->names('blog.categories')->parameters(['categories' => 'category'])->except('show');
    Route::resource('blog/tags', AdminBlogTagController::class)->names('blog.tags')->parameters(['tags' => 'tag'])->except('show');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('coupons', AdminCouponController::class)->except('show');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});

require __DIR__.'/auth.php';
