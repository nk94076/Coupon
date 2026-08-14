<?php

namespace App\Policies;

use App\Models\AdminUser;

/**
 * Every method here returns false because only Super Admins may manage
 * admin users, and Super Admins already bypass policies entirely via the
 * Gate::before hook in AppServiceProvider. Self-lockout protection (an
 * admin can't delete/deactivate their own account) is enforced in
 * AdminUserController, since Gate::before would otherwise short-circuit it.
 */
class AdminUserPolicy
{
    public function viewAny(AdminUser $admin): bool
    {
        return false;
    }

    public function view(AdminUser $admin, AdminUser $target): bool
    {
        return false;
    }

    public function create(AdminUser $admin): bool
    {
        return false;
    }

    public function update(AdminUser $admin, AdminUser $target): bool
    {
        return false;
    }

    public function delete(AdminUser $admin, AdminUser $target): bool
    {
        return false;
    }
}
