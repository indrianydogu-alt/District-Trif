<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(15);
        return view('admin.promo.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.promo.voucher.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Voucher::create($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher dibuat.');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.promo.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $this->validateData($request, $voucher->id);
        $voucher->update($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher diperbarui.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $rules = [
            'code' => ['required', 'string', 'max:50', Rule::unique('vouchers', 'code')->ignore($ignoreId)],
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ];

        if ($request->input('type') === 'percent') {
            $rules['value'] = 'required|numeric|min:0|max:100';
        }

        $data = $request->validate($rules);
        $data['code'] = strtoupper($data['code']);
        $data['min_purchase'] = $data['min_purchase'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
