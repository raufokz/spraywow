<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'minimum_amount',
        'starts_at',
        'ends_at',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'minimum_amount' => 'decimal:2',
            'value' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Coupon $coupon): void {
            $coupon->code = Str::upper($coupon->code);
        });
    }

    public function isValidFor(float $subtotal): bool
    {
        $now = now();

        return $this->is_active
            && ($this->starts_at === null || $this->starts_at->lte($now))
            && ($this->ends_at === null || $this->ends_at->gte($now))
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit)
            && $subtotal >= (float) $this->minimum_amount;
    }

    public function discountFor(float $subtotal): float
    {
        if (! $this->isValidFor($subtotal)) {
            return 0;
        }

        if ($this->type === 'percent') {
            return round($subtotal * ((float) $this->value / 100), 2);
        }

        return min($subtotal, (float) $this->value);
    }
}
