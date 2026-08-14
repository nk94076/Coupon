<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Services\ActivityLogService;
use App\Services\MediaUploadService;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly MediaUploadService $mediaUploadService) {}

    public function edit(): View
    {
        $this->authorize('manage-settings');

        $settings = SettingsService::all();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['maintenance_mode'] = $request->boolean('maintenance_mode') ? '1' : '0';

        $current = SettingsService::all();

        foreach (['logo', 'favicon', 'default_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->mediaUploadService->replaceFile($request->file($field), 'settings', $current[$field] ?? null);
            } else {
                unset($data[$field]);
            }
        }

        $groups = [
            'site_name' => 'general', 'site_url' => 'general', 'logo' => 'general', 'favicon' => 'general',
            'contact_email' => 'general', 'default_currency' => 'general', 'default_country' => 'general',
            'default_meta_title' => 'seo', 'default_meta_description' => 'seo', 'default_og_image' => 'seo',
            'gsc_verification' => 'seo', 'ga_id' => 'seo',
            'maintenance_mode' => 'system', 'default_pagination' => 'system', 'timezone' => 'system',
        ];

        $payload = [];
        foreach ($data as $key => $value) {
            $payload[$key] = ['value' => $value, 'group' => $groups[$key] ?? 'general'];
        }

        SettingsService::setMany($payload);

        ActivityLogService::log('update', 'settings', description: 'Admin updated global settings');

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated successfully.');
    }
}
