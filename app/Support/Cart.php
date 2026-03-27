<?php

namespace App\Support;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Cart
{
    public function __construct(protected Session $session)
    {
    }

    public function items(): Collection
    {
        $items = collect($this->session->get('cart.items', []));

        if ($items->isEmpty()) {
            return collect();
        }

        $products = Product::query()
            ->with('category')
            ->whereIn('id', $items->keys())
            ->get()
            ->keyBy('id');

        return $items->map(function (int $quantity, int|string $productId) use ($products) {
            $product = $products->get((int) $productId);

            if (! $product) {
                return null;
            }

            $qty = min(max($quantity, 1), $product->stock);

            return [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => round($qty * (float) $product->price, 2),
            ];
        })->filter()->values();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $items = $this->session->get('cart.items', []);
        $current = $items[$product->id] ?? 0;
        $items[$product->id] = min($product->stock, max(1, $current + $quantity));
        $this->session->put('cart.items', $items);
    }

    public function update(Product $product, int $quantity): void
    {
        $items = $this->session->get('cart.items', []);

        if ($quantity <= 0) {
            unset($items[$product->id]);
        } else {
            $items[$product->id] = min($product->stock, $quantity);
        }

        $this->session->put('cart.items', $items);
    }

    public function remove(Product $product): void
    {
        $items = $this->session->get('cart.items', []);
        unset($items[$product->id]);
        $this->session->put('cart.items', $items);
    }

    public function flush(): void
    {
        $this->session->forget(['cart.items', 'cart.coupon_code']);
    }

    public function subtotal(): float
    {
        return round($this->items()->sum('line_total'), 2);
    }

    public function shippingTotal(): float
    {
        return $this->subtotal() >= 75 || $this->subtotal() === 0.0 ? 0.0 : 7.99;
    }

    public function coupon(): ?Coupon
    {
        $code = $this->session->get('cart.coupon_code');

        if (! $code) {
            return null;
        }

        $coupon = Coupon::query()->where('code', $code)->first();

        return $coupon && $coupon->isValidFor($this->subtotal()) ? $coupon : null;
    }

    public function setCoupon(?Coupon $coupon): void
    {
        if ($coupon) {
            $this->session->put('cart.coupon_code', $coupon->code);
            return;
        }

        $this->session->forget('cart.coupon_code');
    }

    public function discountTotal(): float
    {
        return round($this->coupon()?->discountFor($this->subtotal()) ?? 0, 2);
    }

    public function total(): float
    {
        return round(max(0, $this->subtotal() + $this->shippingTotal() - $this->discountTotal()), 2);
    }

    public function count(): int
    {
        return (int) $this->items()->sum('quantity');
    }

    public function summary(): array
    {
        return [
            'items' => $this->items(),
            'subtotal' => $this->subtotal(),
            'shipping_total' => $this->shippingTotal(),
            'discount_total' => $this->discountTotal(),
            'total' => $this->total(),
            'coupon' => $this->coupon(),
            'count' => $this->count(),
        ];
    }
}
