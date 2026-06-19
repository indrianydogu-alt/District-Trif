<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $fillable = ['qris_image'];

    public function getQrisUrlAttribute(): ?string
    {
        return $this->qris_image ? asset('storage/' . $this->qris_image) : null;
    }

    public static function current(): self
    {
        return static::firstOrCreate([]);
    }
}
