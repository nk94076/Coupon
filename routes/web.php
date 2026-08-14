<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes
|--------------------------------------------------------------------------
|
| Phase 1 ships the Admin CMS only. The public coupon website (/coupons,
| /stores, /categories, /{store}-coupons, ...) is built in a later phase
| and will live in this file, kept separate from routes/admin.php.
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});
