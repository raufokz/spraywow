<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Your Cart | SprayWow</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body>
    @include('storefront.partials.header')
    <div class="shell py-8">
        <div class="mb-6">
            <h1 class="text-4xl font-semibold text-white">Shopping cart</h1>
            <p class="mt-2 text-sm text-slate-200">A friendlier checkout starts here. Review your products, tweak quantities, and head to payment when you're ready.</p>
        </div>
        <div class="grid gap-8 lg:grid-cols-[1.1fr_.9fr]">
            <div class="glass-panel p-6">
                <div class="space-y-4">
                    @forelse($cart['items'] as $item)
                        <div class="flex flex-col gap-4 rounded-[24px] border border-sky-100 p-4 sm:flex-row sm:items-center">
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="h-28 w-28 rounded-[20px] bg-sky-50 p-3">
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-slate-950">{{ $item['product']->name }}</h2>
                                <p class="text-sm text-slate-500">{{ $item['product']->sku }}</p>
                                <p class="mt-1 text-sm text-slate-600">${{ number_format($item['product']->price, 2) }} each</p>
                            </div>
                            <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <input type="number" min="0" name="quantity" value="{{ $item['quantity'] }}" class="w-20 rounded-2xl border border-sky-100 px-3 py-2 text-slate-900">
                                <button class="btn-secondary !px-4 !py-2">Update</button>
                            </form>
                            <form method="POST" action="{{ route('cart.destroy', $item['product']) }}">@csrf @method('DELETE')<button class="text-sm font-semibold text-rose-600">Remove</button></form>
                        </div>
                    @empty
                        <p class="rounded-[24px] border border-sky-100 bg-sky-50 p-6 text-slate-600">Your cart is empty.</p>
                    @endforelse
                </div>
            </div>
            <div class="glass-panel p-6">
                <h2 class="text-2xl font-semibold text-slate-950">Order summary</h2>
                <form method="POST" action="{{ route('cart.coupon.store') }}" class="mt-4 flex gap-2">@csrf<input type="text" name="code" placeholder="Promo code" class="flex-1 rounded-2xl border border-sky-100 px-4 py-3 text-slate-900"><button class="btn-secondary !px-4 !py-3">Apply</button></form>
                @if($cart['coupon'])
                    <form method="POST" action="{{ route('cart.coupon.destroy') }}" class="mt-3">@csrf @method('DELETE')<button class="text-sm font-semibold text-rose-600">Remove {{ $cart['coupon']->code }}</button></form>
                @endif
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($cart['subtotal'], 2) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($cart['shipping_total'], 2) }}</span></div>
                    <div class="flex justify-between"><span>Discount</span><span>- ${{ number_format($cart['discount_total'], 2) }}</span></div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-semibold text-slate-950"><span>Total</span><span>${{ number_format($cart['total'], 2) }}</span></div>
                </div>
                @auth
                    <a href="{{ route('checkout.index') }}" class="btn-primary mt-6 w-full">Proceed to checkout</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary mt-6 w-full">Login to checkout</a>
                @endauth
            </div>
        </div>
    </div>
    @include('storefront.partials.footer')
</body>
</html>
