<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Order Confirmed | SprayWow</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body>
    @include('storefront.partials.header')
    <div class="shell py-16">
        <div class="glass-panel mx-auto max-w-3xl p-10 text-center">
            <p class="eyebrow !text-slate-700 !border-sky-200 !bg-sky-100/80">Order placed</p>
            <h1 class="text-4xl font-semibold text-slate-950">Thanks for choosing SprayWow.</h1>
            <p class="mt-4 text-slate-600">Your order <span class="font-semibold">{{ $order->order_number }}</span> has been received and is now being prepared.</p>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-[24px] border border-sky-100 bg-sky-50/70 p-5"><p class="text-sm text-slate-500">Status</p><p class="mt-2 font-semibold text-slate-950">{{ ucfirst($order->status) }}</p></div>
                <div class="rounded-[24px] border border-sky-100 bg-sky-50/70 p-5"><p class="text-sm text-slate-500">Payment</p><p class="mt-2 font-semibold text-slate-950">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p></div>
                <div class="rounded-[24px] border border-sky-100 bg-sky-50/70 p-5"><p class="text-sm text-slate-500">Total</p><p class="mt-2 font-semibold text-slate-950">${{ number_format($order->total, 2) }}</p></div>
            </div>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('account.orders.show', $order) }}" class="btn-primary">Track order</a>
                <a href="{{ route('products.index') }}" class="btn-secondary">Keep shopping</a>
            </div>
        </div>
    </div>
    @include('storefront.partials.footer')
</body>
</html>
