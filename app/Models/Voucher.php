<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'max_uses',
        'used_count',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'used_count' => 'integer',
        'max_uses' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isUsable(float $subtotal): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->ends_at && now()->gt($this->ends_at)) return false;
        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) return false;
        if ($subtotal < (float) $this->min_purchase) return false;
        return true;
    }

    public function calcDiscount(float $subtotal): float
    {
        $disc = $this->type === 'percent'
            ? $subtotal * ((float) $this->value / 100)
            : (float) $this->value;
        return min($disc, $subtotal);
    }
}
