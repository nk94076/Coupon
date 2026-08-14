<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin CMS Routes
|--------------------------------------------------------------------------
|
| Everything here lives under /admin and is completely separate from the
| public coupon website that later phases will build in routes/web.php.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only authentication routes.
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    });

    // Authenticated admin routes.
    Route::middleware(['auth:admin', 'admin.active'])->group(function () {
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/', DashboardController::class)->name('home');
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('stores', StoreController::class)->except(['show']);
        Route::patch('stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])->name('stores.toggle-status');
        Route::patch('stores/{store}/toggle-featured', [StoreController::class, 'toggleFeatured'])->name('stores.toggle-featured');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::patch('categories/{category}/toggle-featured', [CategoryController::class, 'toggleFeatured'])->name('categories.toggle-featured');

        Route::resource('coupons', CouponController::class)->except(['show']);
        Route::patch('coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        Route::patch('coupons/{coupon}/toggle-featured', [CouponController::class, 'toggleFeatured'])->name('coupons.toggle-featured');
        Route::patch('coupons/{coupon}/toggle-exclusive', [CouponController::class, 'toggleExclusive'])->name('coupons.toggle-exclusive');
        Route::patch('coupons/{coupon}/toggle-verified', [CouponController::class, 'toggleVerified'])->name('coupons.toggle-verified');

        Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy']);

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::put('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');

        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
