<?php

namespace App\Providers;

use App\Models\AdminUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super admins bypass every policy/gate check.
        Gate::before(fn (AdminUser $admin) => $admin->isSuperAdmin() ? true : null);

        // Admin users and system settings are Super Admin only; Managers are
        // deliberately excluded (they may manage stores/categories/coupons,
        // covered by the per-model policies instead).
        Gate::define('manage-admins', fn (AdminUser $admin) => $admin->isSuperAdmin());
        Gate::define('manage-settings', fn (AdminUser $admin) => $admin->isSuperAdmin());

        if (! $this->app->isLocal()) {
            URL::forceScheme('https');
        }
    }
}
