<?php

namespace Database\Seeders;

use App\Enums\AdminRole;
use App\Enums\Status;
use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::updateOrCreate(
            ['email' => env('SEED_ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('SEED_ADMIN_NAME', 'Super Admin'),
                'password' => Hash::make(env('SEED_ADMIN_PASSWORD', 'ChangeMe123!')),
                'role' => AdminRole::SuperAdmin,
                'status' => Status::Active,
            ]
        );

        AdminUser::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Demo Manager',
                'password' => Hash::make('ChangeMe123!'),
                'role' => AdminRole::Manager,
                'status' => Status::Active,
            ]
        );
    }
}
