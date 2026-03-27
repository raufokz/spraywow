<footer class="brand-footer mt-16 py-14 text-slate-200">
    <div class="shell grid gap-10 lg:grid-cols-[1.2fr_.8fr_.8fr_.8fr]">
        <div>
            <img src="{{ asset('images/spraywow.webp') }}" alt="SprayWow" class="h-16 w-auto">
            <p class="mt-4 max-w-md text-sm leading-7 text-slate-300">
                SprayWow is built to feel helpful, familiar, and premium at the same time. Fast sprays, fresh finishes, and formulas made for real daily messes.
            </p>
            <div class="mt-5 flex flex-wrap gap-2 text-xs sm:text-sm">
                <span class="rounded-full border border-cyan-200/20 bg-white/8 px-3 py-1">Free shipping over $75</span>
                <span class="rounded-full border border-cyan-200/20 bg-white/8 px-3 py-1">Stripe + COD</span>
                <span class="rounded-full border border-cyan-200/20 bg-white/8 px-3 py-1">Fast dispatch</span>
            </div>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-white">Shop</h4>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li><a href="{{ route('products.index') }}" class="hover:text-cyan-200">All products</a></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-cyan-200">Cleaning blog</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-cyan-200">About SprayWow</a></li>
                <li><a href="{{ route('products.index', ['category' => 'home-cleaning']) }}" class="hover:text-cyan-200">Home cleaning</a></li>
                <li><a href="{{ route('products.index', ['category' => 'shoe-care']) }}" class="hover:text-cyan-200">Shoe care</a></li>
                <li><a href="{{ route('products.index', ['category' => 'pest-control']) }}" class="hover:text-cyan-200">Pest control</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-white">Customer Care</h4>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li><a href="{{ route('cart.index') }}" class="hover:text-cyan-200">Cart</a></li>
                <li><a href="{{ route('checkout.index') }}" class="hover:text-cyan-200">Checkout</a></li>
                <li><a href="{{ route('account.orders.index') }}" class="hover:text-cyan-200">Track orders</a></li>
                <li><span>Support: hello@spraywow.com</span></li>
            </ul>
        </div>
        <div>
            <h4 class="text-lg font-semibold text-white">Why SprayWow</h4>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li>Human-friendly product descriptions</li>
                <li>Fresh, clean, non-clinical branding</li>
                <li>Everyday household and care sprays</li>
                <li>Built for fast shopping on mobile and desktop</li>
            </ul>
        </div>
    </div>
</footer>
