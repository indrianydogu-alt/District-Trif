<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $banks = BankAccount::orderBy('bank_name')->get();
        $setting = PaymentSetting::current();
        return view('admin.settings.index', compact('banks', 'setting'));
    }

    public function storeBank(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        BankAccount::create($data);
        return back()->with('success', 'Rekening ditambahkan.');
    }

    public function updateBank(Request $request, BankAccount $bank)
    {
        $data = $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $bank->update($data);
        return back()->with('success', 'Rekening diperbarui.');
    }

    public function destroyBank(BankAccount $bank)
    {
        $bank->delete();
        return back()->with('success', 'Rekening dihapus.');
    }

    public function updateQris(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|max:250',
        ]);

        $setting = PaymentSetting::current();
        if ($setting->qris_image) {
            Storage::disk('public')->delete($setting->qris_image);
        }

        $path = $request->file('qris_image')->store('qris', 'public');
        $setting->update(['qris_image' => $path]);

        return back()->with('success', 'QR Code QRIS berhasil diperbarui.');
    }
}
