<?php

namespace App\Services;

class ShippingCalculator
{
    private const ORIGIN = 'Purwokerto, Jawa Tengah';

    private const PROVINCES = [
        'Jawa Tengah' => ['distance_km' => 25, 'cost' => 12000],
        'DI Yogyakarta' => ['distance_km' => 170, 'cost' => 18000],
        'Jawa Barat' => ['distance_km' => 285, 'cost' => 24000],
        'DKI Jakarta' => ['distance_km' => 360, 'cost' => 28000],
        'Banten' => ['distance_km' => 430, 'cost' => 32000],
        'Jawa Timur' => ['distance_km' => 430, 'cost' => 32000],
        'Bali' => ['distance_km' => 780, 'cost' => 45000],
        'Lampung' => ['distance_km' => 610, 'cost' => 40000],
        'Sumatera Selatan' => ['distance_km' => 850, 'cost' => 52000],
        'Bengkulu' => ['distance_km' => 950, 'cost' => 58000],
        'Jambi' => ['distance_km' => 1050, 'cost' => 62000],
        'Kepulauan Bangka Belitung' => ['distance_km' => 730, 'cost' => 50000],
        'Kepulauan Riau' => ['distance_km' => 1180, 'cost' => 68000],
        'Riau' => ['distance_km' => 1300, 'cost' => 72000],
        'Sumatera Barat' => ['distance_km' => 1320, 'cost' => 74000],
        'Sumatera Utara' => ['distance_km' => 1850, 'cost' => 88000],
        'Aceh' => ['distance_km' => 2300, 'cost' => 98000],
        'Kalimantan Barat' => ['distance_km' => 920, 'cost' => 62000],
        'Kalimantan Tengah' => ['distance_km' => 890, 'cost' => 65000],
        'Kalimantan Selatan' => ['distance_km' => 760, 'cost' => 60000],
        'Kalimantan Timur' => ['distance_km' => 1150, 'cost' => 78000],
        'Kalimantan Utara' => ['distance_km' => 1450, 'cost' => 90000],
        'Sulawesi Selatan' => ['distance_km' => 1100, 'cost' => 76000],
        'Sulawesi Barat' => ['distance_km' => 1200, 'cost' => 80000],
        'Sulawesi Tengah' => ['distance_km' => 1350, 'cost' => 86000],
        'Sulawesi Tenggara' => ['distance_km' => 1300, 'cost' => 84000],
        'Gorontalo' => ['distance_km' => 1600, 'cost' => 94000],
        'Sulawesi Utara' => ['distance_km' => 1800, 'cost' => 98000],
        'Nusa Tenggara Barat' => ['distance_km' => 980, 'cost' => 65000],
        'Nusa Tenggara Timur' => ['distance_km' => 1500, 'cost' => 92000],
        'Maluku' => ['distance_km' => 1900, 'cost' => 110000],
        'Maluku Utara' => ['distance_km' => 2100, 'cost' => 118000],
        'Papua Barat Daya' => ['distance_km' => 2500, 'cost' => 135000],
        'Papua Barat' => ['distance_km' => 2600, 'cost' => 140000],
        'Papua Tengah' => ['distance_km' => 2850, 'cost' => 150000],
        'Papua Pegunungan' => ['distance_km' => 2950, 'cost' => 158000],
        'Papua Selatan' => ['distance_km' => 3000, 'cost' => 160000],
        'Papua' => ['distance_km' => 3200, 'cost' => 170000],
    ];

    public static function origin(): string
    {
        return self::ORIGIN;
    }

    public static function provinces(): array
    {
        return self::PROVINCES;
    }

    public static function provinceNames(): array
    {
        return array_keys(self::PROVINCES);
    }

    public static function forProvince(string $province): array
    {
        return self::PROVINCES[$province] ?? ['distance_km' => 0, 'cost' => 0];
    }
}
