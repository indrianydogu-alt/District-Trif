<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'subtotal',
        'quantity_discount',
        'voucher_code',
        'voucher_discount',
        'total_price',
        'status',
        'shipping_address',
        'shipping_province',
        'shipping_city',
        'shipping_district',
        'shipping_detail',
        'shipping_distance_km',
        'shipping_cost',
        'shipping_courier',
        'shipping_service',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'subtotal'         => 'decimal:2',
        'quantity_discount'=> 'decimal:2',
        'voucher_discount' => 'decimal:2',
        'shipping_cost'    => 'decimal:2',
        'total_price'      => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function shipmentHistories(): HasMany
    {
        return $this->hasMany(ShipmentHistory::class)->orderBy('created_at', 'asc');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'         => 'bg-secondary',
            'pending_payment' => 'bg-secondary',
            'paid'            => 'bg-info text-dark',
            'processing'      => 'bg-warning text-dark',
            'shipped'         => 'bg-primary',
            'delivered'       => 'bg-success',
            'completed'       => 'bg-success',
            'cancelled'       => 'bg-danger',
            default           => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'         => 'Menunggu',
            'pending_payment' => 'Menunggu Pembayaran',
            'paid'            => 'Dibayar',
            'processing'      => 'Diproses',
            'shipped'         => 'Dikirim',
            'delivered'       => 'Diterima',
            'completed'       => 'Selesai',
            'cancelled'       => 'Dibatalkan',
            default           => ucfirst($this->status),
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid'   => 'bg-secondary',
            'paid'     => 'bg-success',
            'rejected' => 'bg-danger',
            default    => 'bg-secondary',
        };
    }

    public function getPaymentLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'unpaid'   => 'Belum Dibayar',
            'paid'     => 'Dibayar',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->payment_status),
        };
    }
}
