<x-admin-layout title="Settings">
    <x-ui.page-header title="Settings" description="Global configuration for the CMS." />

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <x-ui.panel title="General">
            <div class="space-y-5">
                <x-ui.input label="Website Name" name="site_name" :value="old('site_name', $settings['site_name'] ?? config('app.name'))" required />
                <x-ui.input label="Website URL" name="site_url" type="url" :value="old('site_url', $settings['site_url'] ?? config('app.url'))" />

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Logo</label>
                        @if (! empty($settings['logo']))
                            <img src="{{ media_url($settings['logo']) }}" class="mb-2 h-12 rounded border border-slate-200 bg-white p-1">
                        @endif
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Favicon</label>
                        @if (! empty($settings['favicon']))
                            <img src="{{ media_url($settings['favicon']) }}" class="mb-2 h-8 w-8 rounded border border-slate-200 bg-white p-1">
                        @endif
                        <input type="file" name="favicon" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <x-ui.input label="Contact Email" name="contact_email" type="email" :value="old('contact_email', $settings['contact_email'] ?? '')" />

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-ui.input label="Default Currency" name="default_currency" :value="old('default_currency', $settings['default_currency'] ?? 'USD')" hint="e.g. USD, INR, EUR" />
                    <x-ui.input label="Default Country" name="default_country" :value="old('default_country', $settings['default_country'] ?? '')" />
                </div>
            </div>
        </x-ui.panel>

        <x-ui.panel title="Basic SEO" description="Default fallbacks used until the full SEO engine ships in a later phase.">
            <div class="space-y-5">
                <x-ui.input label="Default Meta Title" name="default_meta_title" :value="old('default_meta_title', $settings['default_meta_title'] ?? '')" />
                <x-ui.textarea label="Default Meta Description" name="default_meta_description" :value="old('default_meta_description', $settings['default_meta_description'] ?? '')" :rows="2" />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Default OG Image</label>
                    @if (! empty($settings['default_og_image']))
                        <img src="{{ media_url($settings['default_og_image']) }}" class="mb-2 h-16 w-28 rounded border border-slate-200 object-cover">
                    @endif
                    <input type="file" name="default_og_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <x-ui.input label="Google Search Console Verification" name="gsc_verification" :value="old('gsc_verification', $settings['gsc_verification'] ?? '')" />
                <x-ui.input label="Google Analytics ID" name="ga_id" :value="old('ga_id', $settings['ga_id'] ?? '')" placeholder="G-XXXXXXX" />
            </div>
        </x-ui.panel>

        <x-ui.panel title="System">
            <div class="space-y-5">
                <x-ui.checkbox label="Maintenance Mode" name="maintenance_mode" hint="Reserved for future public site use." :checked="($settings['maintenance_mode'] ?? '0') === '1'" />
                <x-ui.input label="Default Pagination" name="default_pagination" type="number" min="5" max="100" :value="old('default_pagination', $settings['default_pagination'] ?? 15)" required />
                <x-ui.select label="Timezone" name="timezone" :options="array_combine(\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers())" :selected="old('timezone', $settings['timezone'] ?? config('app.timezone'))" required />
            </div>
        </x-ui.panel>

        <x-ui.button type="submit">Save Settings</x-ui.button>
    </form>
</x-admin-layout>
