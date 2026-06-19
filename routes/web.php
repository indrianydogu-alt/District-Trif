<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\QuantityDiscountController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShipmentController as AdminShipmentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\CheckoutController;
use App\Http\Controllers\Pembeli\HomeController;
use App\Http\Controllers\Pembeli\OrderController as PembeliOrderController;
use App\Http\Controllers\Pembeli\PaymentController as PembeliPaymentController;
use App\Http\Controllers\Pembeli\ProductController as PembeliProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products.index');
Route::get('/products/{slug}', [PembeliProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [PembeliOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PembeliOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [PembeliOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/confirm-received', [PembeliOrderController::class, 'confirmReceived'])->name('orders.confirmReceived');

    Route::get('/orders/{order}/payment', [PembeliPaymentController::class, 'upload'])->name('payment.upload');
    Route::post('/orders/{order}/payment', [PembeliPaymentController::class, 'store'])->name('payment.store');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('users', AdminUserController::class);
    Route::resource('shipments', AdminShipmentController::class);
    Route::resource('vouchers', VoucherController::class)->except('show');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])->name('payments.confirm');
    Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

    Route::post('/shipments/{shipment}/status', [AdminShipmentController::class, 'updateStatus'])->name('shipments.updateStatus');

    Route::get('/quantity-discount', [QuantityDiscountController::class, 'index'])->name('quantity-discount.index');
    Route::post('/quantity-discount', [QuantityDiscountController::class, 'update'])->name('quantity-discount.update');

    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top-products');
    Route::get('/reports/top-customers', [ReportController::class, 'topCustomers'])->name('reports.top-customers');
    Route::get('/reports/vouchers', [ReportController::class, 'vouchers'])->name('reports.vouchers');
    Route::get('/reports/shipments', [ReportController::class, 'shipments'])->name('reports.shipments');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/bank', [SettingsController::class, 'storeBank'])->name('settings.bank.store');
    Route::put('/settings/bank/{bank}', [SettingsController::class, 'updateBank'])->name('settings.bank.update');
    Route::delete('/settings/bank/{bank}', [SettingsController::class, 'destroyBank'])->name('settings.bank.destroy');
    Route::post('/settings/qris', [SettingsController::class, 'updateQris'])->name('settings.qris.update');
});

require __DIR__.'/auth.php';
