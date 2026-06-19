<?php

namespace App\Services;

use App\Models\QuantityDiscount;
use App\Models\Voucher;

class PromoCalculator
{
    public static function quantityDiscount(int $totalItems, float $subtotal): array
    {
        if ($totalItems <= 0 || $subtotal <= 0) {
            return ['percent' => 0, 'amount' => 0.0];
        }

        $tier = QuantityDiscount::where('is_active', true)
            ->where('min_items', '<=', $totalItems)
            ->orderByDesc('min_items')
            ->first();

        if (!$tier) {
            return ['percent' => 0, 'amount' => 0.0];
        }

        $amount = round($subtotal * ($tier->discount_percent / 100), 2);
        return ['percent' => $tier->discount_percent, 'amount' => $amount];
    }

    public static function applyVoucher(?string $code, float $subtotal): array
    {
        if (!$code) {
            return ['voucher' => null, 'amount' => 0.0, 'error' => null];
        }

        $voucher = Voucher::where('code', $code)->first();
        if (!$voucher) {
            return ['voucher' => null, 'amount' => 0.0, 'error' => 'Kode voucher tidak ditemukan.'];
        }
        if (!$voucher->isUsable($subtotal)) {
            return ['voucher' => null, 'amount' => 0.0, 'error' => 'Voucher tidak dapat digunakan (kadaluarsa, kuota habis, atau minimum belanja kurang).'];
        }

        return [
            'voucher' => $voucher,
            'amount' => round($voucher->calcDiscount($subtotal), 2),
            'error' => null,
        ];
    }

    public static function summary(int $totalItems, float $subtotal, ?string $voucherCode = null): array
    {
        $qty = self::quantityDiscount($totalItems, $subtotal);
        $vou = self::applyVoucher($voucherCode, $subtotal);

        $total = max(0, $subtotal - $qty['amount'] - $vou['amount']);

        return [
            'subtotal' => $subtotal,
            'quantity_discount' => $qty['amount'],
            'quantity_discount_percent' => $qty['percent'],
            'voucher' => $vou['voucher'],
            'voucher_discount' => $vou['amount'],
            'voucher_error' => $vou['error'],
            'total' => $total,
        ];
    }
}
