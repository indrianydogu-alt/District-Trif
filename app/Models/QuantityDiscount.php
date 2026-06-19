<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['min_items', 'discount_percent', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'min_items' => 'integer',
        'discount_percent' => 'integer',
    ];
}
