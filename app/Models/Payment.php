<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'method', 'status', 'proof_image'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getProofUrlAttribute(): ?string
    {
        return $this->proof_image ? asset('storage/' . $this->proof_image) : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'bg-warning text-dark',
            'confirmed' => 'bg-success',
            'rejected'  => 'bg-danger',
            default     => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'rejected'  => 'Ditolak',
            default     => ucfirst($this->status),
        };
    }
}
