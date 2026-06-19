<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'pembeli')->withCount('orders');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.user.index', [
            'users' => $users,
            'q' => $request->q,
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'pembeli';

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'pembeli', 404);

        $orders = $user->orders()->with('items')->latest()->paginate(10);

        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => (float) $user->orders()->where('payment_status', 'paid')->sum('total_price'),
            'last_order_at' => $user->orders()->latest()->value('created_at'),
        ];

        return view('admin.user.show', compact('user', 'orders', 'stats'));
    }

    public function edit(User $user)
    {
        abort_if($user->role !== 'pembeli', 404);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'pembeli', 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user)->with('success', 'Data pelanggan diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'pembeli', 404);

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pelanggan dihapus.');
    }
}
