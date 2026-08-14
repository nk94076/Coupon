<?php

namespace App\Policies;

use App\Models\AdminUser;
use App\Models\Category;

class CategoryPolicy
{
    public function viewAny(AdminUser $admin): bool
    {
        return true;
    }

    public function view(AdminUser $admin, Category $category): bool
    {
        return true;
    }

    public function create(AdminUser $admin): bool
    {
        return true;
    }

    public function update(AdminUser $admin, Category $category): bool
    {
        return true;
    }

    public function delete(AdminUser $admin, Category $category): bool
    {
        return true;
    }
}
