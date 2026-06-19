<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    use HasFactory;

    public const COURIERS = ['JNE', 'J&T', 'SiCepat', 'POS', 'AnterAja'];
    public const SERVICES = ['REG', 'YES', 'OKE'];
    public const STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'returned'];

    // Status yang boleh diubah admin (TIDAK termasuk delivered)
    public const ADMIN_ALLOWED_STATUSES = ['processing', 'shipped'];

    protected $fillable = [
        'order_id',
        'courier',
        'service',
        'tracking_number',
        'shipping_cost',
        'status',
        'shipped_at',
        'delivered_at',
        'received_at',
        'notes',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
        'received_at'   => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-secondary',
            'processing' => 'bg-warning text-dark',
            'shipped'    => 'bg-primary',
            'delivered'  => 'bg-success',
            'returned'   => 'bg-danger',
            default      => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'delivered'  => 'Diterima',
            'returned'   => 'Dikembalikan',
            default      => ucfirst($this->status),
        };
    }
}
