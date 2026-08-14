<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-settings');
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // General
            'site_name' => ['required', 'string', 'max:255'],
            'site_url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('media.max_size_kb')],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('media.max_size_kb')],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'default_currency' => ['nullable', 'string', 'max:10'],
            'default_country' => ['nullable', 'string', 'max:100'],

            // SEO
            'default_meta_title' => ['nullable', 'string', 'max:255'],
            'default_meta_description' => ['nullable', 'string', 'max:500'],
            'default_og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('media.max_size_kb')],
            'gsc_verification' => ['nullable', 'string', 'max:255'],
            'ga_id' => ['nullable', 'string', 'max:50'],

            // System
            'maintenance_mode' => ['sometimes', 'boolean'],
            'default_pagination' => ['required', 'integer', 'min:5', 'max:100'],
            'timezone' => ['required', 'string', 'max:100', 'timezone'],
        ];
    }
}
