<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuantityDiscount;
use Illuminate\Http\Request;

class QuantityDiscountController extends Controller
{
    public function index()
    {
        $tiers = QuantityDiscount::orderBy('min_items')->get();
        return view('admin.promo.quantity', compact('tiers'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tiers' => 'required|array',
            'tiers.*.id' => 'required|exists:quantity_discounts,id',
            'tiers.*.min_items' => 'required|integer|min:1',
            'tiers.*.discount_percent' => 'required|integer|min:0|max:100',
            'tiers.*.is_active' => 'nullable|boolean',
        ]);

        foreach ($data['tiers'] as $row) {
            QuantityDiscount::where('id', $row['id'])->update([
                'min_items' => $row['min_items'],
                'discount_percent' => $row['discount_percent'],
                'is_active' => !empty($row['is_active']),
            ]);
        }

        return back()->with('success', 'Pengaturan diskon otomatis disimpan.');
    }
}
