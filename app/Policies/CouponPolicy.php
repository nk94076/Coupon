<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Coupon;

class CouponPolicy
{
    public function viewAny(AdminUser $admin): bool
    {
        return true;
    }

    public function view(AdminUser $admin, Coupon $coupon): bool
    {
        return true;
    }

    public function create(AdminUser $admin): bool
    {
        return true;
    }

    public function update(AdminUser $admin, Coupon $coupon): bool
    {
        return true;
    }

    public function delete(AdminUser $admin, Coupon $coupon): bool
    {
        return true;
    }
}
