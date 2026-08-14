<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Store;

class StorePolicy
{
    public function viewAny(AdminUser $admin): bool
    {
        return true;
    }

    public function view(AdminUser $admin, Store $store): bool
    {
        return true;
    }

    public function create(AdminUser $admin): bool
    {
        return true;
    }

    public function update(AdminUser $admin, Store $store): bool
    {
        return true;
    }

    public function delete(AdminUser $admin, Store $store): bool
    {
        return true;
    }
}
