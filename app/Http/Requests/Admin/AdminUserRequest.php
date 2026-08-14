<?php

namespace App\Http\Requests\Admin;

use App\Enums\AdminRole;
use App\Enums\Status;
use App\Models\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var AdminUser|null $user */
        $user = $this->route('user');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin_users', 'email')->ignore($user)],
            'role' => ['required', Rule::enum(AdminRole::class)],
            'status' => ['required', Rule::enum(Status::class)],
        ];

        if (! $user) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        return $rules;
    }
}
