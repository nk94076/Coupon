<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total_stores' => Store::count(),
            'active_stores' => Store::active()->count(),
            'total_categories' => Category::count(),
            'total_coupons' => Coupon::count(),
            'active_coupons' => Coupon::active()->count(),
            'expired_coupons' => Coupon::expired()->count(),
            'featured_coupons' => Coupon::featured()->count(),
        ];

        $recentStores = Store::with('category')->latest()->take(5)->get();
        $recentCoupons = Coupon::with('store')->latest()->take(10)->get();
        $recentCategories = Category::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentStores', 'recentCoupons', 'recentCategories'));
    }
}
