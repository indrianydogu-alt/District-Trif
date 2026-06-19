<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentHistory extends Model
{
    protected $table = 'shipment_history';

    protected $fillable = [
        'order_id',
        'status',
        'description',
        'created_by',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'bg-secondary',
            'paid'            => 'bg-info text-dark',
            'processing'      => 'bg-warning text-dark',
            'shipped'         => 'bg-primary',
            'completed'       => 'bg-success',
            'cancelled'       => 'bg-danger',
            default           => 'bg-secondary',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'bi-clock',
            'paid'            => 'bi-credit-card-fill',
            'processing'      => 'bi-gear-fill',
            'shipped'         => 'bi-truck',
            'completed'       => 'bi-check-circle-fill',
            'cancelled'       => 'bi-x-circle-fill',
            default           => 'bi-circle',
        };
    }
}
