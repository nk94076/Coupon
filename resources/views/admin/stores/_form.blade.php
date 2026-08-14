@php $store = $store ?? null; @endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <x-ui.panel title="Basic Information">
            <div class="space-y-5">
                <x-ui.input label="Store Name" name="name" :value="$store?->name" required />

                <x-ui.input
                    label="Slug"
                    name="slug"
                    :value="$store?->slug"
                    hint="Leave blank to auto-generate from the name. Editing this changes the store's URL."
                />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Store Logo</label>
                    @if ($store?->logo)
                        <img src="{{ media_url($store->logo) }}" alt="{{ $store->name }}" class="mb-2 h-16 w-16 rounded-lg border border-slate-200 object-contain bg-white p-1">
                    @endif
                    <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('logo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <x-ui.input label="Website URL" name="website_url" type="url" :value="$store?->website_url" />
                <x-ui.input label="Affiliate URL" name="affiliate_url" type="url" :value="$store?->affiliate_url" />
                <x-ui.select label="Category" name="category_id" :options="$categories->pluck('name', 'id')" :selected="$store?->category_id" placeholder="Uncategorized" />
                <x-ui.input label="Short Description" name="short_description" :value="$store?->short_description" hint="Shown in listings, keep it brief." />
                <x-ui.textarea label="Full Description" name="description" :value="$store?->description" :rows="6" />
            </div>
        </x-ui.panel>

        <x-ui.panel title="SEO" description="These fields feed the full SEO engine coming in a later phase.">
            <div class="space-y-5">
                <x-ui.input label="Meta Title" name="meta_title" :value="$store?->meta_title" />
                <x-ui.textarea label="Meta Description" name="meta_description" :value="$store?->meta_description" :rows="2" />
                <x-ui.input label="Canonical URL" name="canonical_url" type="url" :value="$store?->canonical_url" />
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <x-ui.checkbox label="Index" name="robots_index" hint="Allow search engines to index this page." :checked="$store?->robots_index ?? true" />
                    <x-ui.checkbox label="Follow" name="robots_follow" hint="Allow search engines to follow links." :checked="$store?->robots_follow ?? true" />
                </div>
                <x-ui.input label="OG Title" name="og_title" :value="$store?->og_title" />
                <x-ui.textarea label="OG Description" name="og_description" :value="$store?->og_description" :rows="2" />
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">OG Image</label>
                    @if ($store?->og_image)
                        <img src="{{ media_url($store->og_image) }}" class="mb-2 h-16 w-28 rounded-lg border border-slate-200 object-cover">
                    @endif
                    <input type="file" name="og_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('og_image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </x-ui.panel>
    </div>

    <div class="space-y-6">
        <x-ui.panel title="Settings">
            <div class="space-y-5">
                <x-ui.select label="Status" name="status" :options="\App\Enums\Status::options()" :selected="$store?->status?->value ?? 'active'" required />
                <x-ui.checkbox label="Featured" name="featured" hint="Show in featured store lists." :checked="$store?->featured ?? false" />
                <x-ui.input label="Sort Order" name="sort_order" type="number" min="0" :value="$store?->sort_order ?? 0" />
            </div>
        </x-ui.panel>

        <x-ui.button type="submit" class="w-full justify-center">{{ $store ? 'Update Store' : 'Create Store' }}</x-ui.button>
    </div>
</div>
