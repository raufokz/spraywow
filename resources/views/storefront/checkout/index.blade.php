<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Checkout | SprayWow</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body>
    @include('storefront.partials.header')
    <div class="shell py-8">
        <div class="mb-6">
            <h1 class="text-4xl font-semibold text-white">Checkout</h1>
            <p class="mt-2 text-sm text-slate-200">Clean layout, clear steps, and a calmer buying experience from address to payment.</p>
        </div>
        <form method="POST" action="{{ route('checkout.store') }}" class="grid gap-8 lg:grid-cols-[1.1fr_.9fr]">
            @csrf
            <div class="glass-panel p-6">
                <div class="grid gap-8 md:grid-cols-2">
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-slate-950">Billing details</h2>
                        <input name="billing_name" value="{{ old('billing_name', auth()->user()->name) }}" placeholder="Full name" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <input name="billing_email" value="{{ old('billing_email', auth()->user()->email) }}" placeholder="Email" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <input name="billing_phone" value="{{ old('billing_phone', auth()->user()->phone) }}" placeholder="Phone" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <input name="billing_address" value="{{ old('billing_address') }}" placeholder="Address" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <div class="grid grid-cols-3 gap-3">
                            <input name="billing_city" value="{{ old('billing_city') }}" placeholder="City" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                            <input name="billing_state" value="{{ old('billing_state') }}" placeholder="State" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                            <input name="billing_zip" value="{{ old('billing_zip') }}" placeholder="ZIP" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-slate-950">Shipping details</h2>
                        <input name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" placeholder="Recipient name" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <input name="shipping_address" value="{{ old('shipping_address') }}" placeholder="Address" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        <div class="grid grid-cols-3 gap-3">
                            <input name="shipping_city" value="{{ old('shipping_city') }}" placeholder="City" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                            <input name="shipping_state" value="{{ old('shipping_state') }}" placeholder="State" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                            <input name="shipping_zip" value="{{ old('shipping_zip') }}" placeholder="ZIP" class="rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                        </div>
                        <select name="payment_method" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">
                            <option value="cod">Cash on Delivery</option>
                            <option value="stripe">Stripe</option>
                        </select>
                        <textarea name="notes" rows="5" placeholder="Order notes" class="w-full rounded-2xl border border-sky-100 px-4 py-3 text-slate-900">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="glass-panel p-6">
                <h2 class="text-2xl font-semibold text-slate-950">Summary</h2>
                <div class="mt-4 space-y-4">
                    @foreach($cart['items'] as $item)
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-4 text-sm text-slate-600">
                            <div><p class="font-semibold text-slate-950">{{ $item['product']->name }}</p><p>Qty {{ $item['quantity'] }}</p></div>
                            <span>${{ number_format($item['line_total'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($cart['subtotal'], 2) }}</span></div>
                    <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($cart['shipping_total'], 2) }}</span></div>
                    <div class="flex justify-between"><span>Discount</span><span>- ${{ number_format($cart['discount_total'], 2) }}</span></div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-semibold text-slate-950"><span>Total</span><span>${{ number_format($cart['total'], 2) }}</span></div>
                </div>
                <button class="btn-primary mt-6 w-full">Place order</button>
                <p class="mt-4 text-xs text-slate-500">Stripe is used when selected and configured. Otherwise, Cash on Delivery remains available.</p>
            </div>
        </form>
    </div>
    @include('storefront.partials.footer')
</body>
</html>
