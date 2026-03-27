<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Invoice {{ $order->order_number }}</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="bg-white">
    <div class="mx-auto max-w-4xl px-6 py-10 text-slate-900">
        <div class="flex items-center justify-between border-b border-slate-200 pb-6">
            <div><p class="text-sm uppercase tracking-[0.3em] text-sky-600">SprayWow invoice</p><h1 class="mt-2 text-3xl font-semibold">{{ $order->order_number }}</h1></div>
            <button onclick="window.print()" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white">Print invoice</button>
        </div>
        <div class="mt-8 grid gap-8 md:grid-cols-2">
            <div><p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Billing</p><p class="mt-3">{{ $order->billing_name }}</p><p>{{ $order->billing_address }}</p><p>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zip }}</p></div>
            <div><p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Shipping</p><p class="mt-3">{{ $order->shipping_name }}</p><p>{{ $order->shipping_address }}</p><p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p></div>
        </div>
        <div class="mt-10 divide-y divide-slate-200 rounded-[24px] border border-slate-200">
            @foreach($order->items as $item)
                <div class="flex items-center justify-between px-5 py-4"><div><p class="font-semibold">{{ $item->product_name }}</p><p class="text-sm text-slate-500">Qty {{ $item->quantity }}</p></div><span>${{ number_format($item->line_total, 2) }}</span></div>
            @endforeach
        </div>
        <div class="mt-8 ml-auto max-w-sm space-y-3">
            <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
            <div class="flex justify-between"><span>Shipping</span><span>${{ number_format($order->shipping_total, 2) }}</span></div>
            <div class="flex justify-between"><span>Discount</span><span>- ${{ number_format($order->discount_total, 2) }}</span></div>
            <div class="flex justify-between border-t border-slate-200 pt-3 text-lg font-semibold"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
        </div>
    </div>
</body>
</html>
