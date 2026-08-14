@php $coupon = $coupon ?? null; @endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <x-ui.panel title="Coupon Information">
            <div class="space-y-5">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-ui.select label="Store" name="store_id" :options="$stores->pluck('name', 'id')" :selected="$coupon?->store_id" placeholder="Select a store" required />
                    <x-ui.select label="Category" name="category_id" :options="$categories->pluck('name', 'id')" :selected="$coupon?->category_id" placeholder="Uncategorized" />
                </div>

                <x-ui.input label="Coupon Title" name="title" :value="$coupon?->title" required />

                <x-ui.input
                    label="Slug"
                    name="slug"
                    :value="$coupon?->slug"
                    hint="Leave blank to auto-generate from the title. Editing this changes the coupon's URL."
                />

                <x-ui.input label="Coupon Code" name="code" :value="$coupon?->code" hint="Leave blank for a codeless deal." />

                <x-ui.textarea label="Description" name="description" :value="$coupon?->description" />
            </div>
        </x-ui.panel>

        <x-ui.panel title="Discount">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.select label="Discount Type" name="discount_type" :options="\App\Enums\DiscountType::options()" :selected="$coupon?->discount_type?->value ?? 'percentage'" required />
                <x-ui.input label="Discount Value" name="discount_value" type="number" step="0.01" min="0" :value="$coupon?->discount_value" />
                <x-ui.input label="Minimum Order" name="minimum_order" type="number" step="0.01" min="0" :value="$coupon?->minimum_order" />
                <x-ui.input label="Maximum Discount" name="maximum_discount" type="number" step="0.01" min="0" :value="$coupon?->maximum_discount" />
            </div>
        </x-ui.panel>

        <x-ui.panel title="Validity">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <x-ui.input label="Start Date" name="start_date" type="date" :value="$coupon?->start_date?->format('Y-m-d')" />
                <x-ui.input label="Expiry Date" name="expiry_date" type="date" :value="$coupon?->expiry_date?->format('Y-m-d')" />
            </div>
        </x-ui.panel>

        <x-ui.panel title="Classification">
            <div class="space-y-5">
                <x-ui.select label="Coupon Type" name="coupon_type" :options="\App\Enums\CouponType::options()" :selected="$coupon?->coupon_type?->value ?? 'general'" required />
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <x-ui.checkbox label="New User" name="is_new_user" :checked="$coupon?->is_new_user ?? false" />
                    <x-ui.checkbox label="App Only" name="is_app_only" :checked="$coupon?->is_app_only ?? false" />
                    <x-ui.checkbox label="Bank Offer" name="is_bank_offer" :checked="$coupon?->is_bank_offer ?? false" />
                    <x-ui.checkbox label="Student" name="is_student" :checked="$coupon?->is_student ?? false" />
                </div>
            </div>
        </x-ui.panel>

        <x-ui.panel title="Affiliate">
            <x-ui.input label="Affiliate URL" name="affiliate_url" type="url" :value="$coupon?->affiliate_url" />
        </x-ui.panel>

        <x-ui.panel title="SEO" description="These fields feed the full SEO engine coming in a later phase.">
            <div class="space-y-5">
                <x-ui.input label="Meta Title" name="meta_title" :value="$coupon?->meta_title" />
                <x-ui.textarea label="Meta Description" name="meta_description" :value="$coupon?->meta_description" :rows="2" />
                <x-ui.input label="Canonical URL" name="canonical_url" type="url" :value="$coupon?->canonical_url" />
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <x-ui.checkbox label="Index" name="robots_index" hint="Allow search engines to index this page." :checked="$coupon?->robots_index ?? true" />
                    <x-ui.checkbox label="Follow" name="robots_follow" hint="Allow search engines to follow links." :checked="$coupon?->robots_follow ?? true" />
                </div>
                <x-ui.input label="OG Title" name="og_title" :value="$coupon?->og_title" />
                <x-ui.textarea label="OG Description" name="og_description" :value="$coupon?->og_description" :rows="2" />
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">OG Image</label>
                    @if ($coupon?->og_image)
                        <img src="{{ media_url($coupon->og_image) }}" class="mb-2 h-16 w-28 rounded-lg border border-slate-200 object-cover">
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
                <x-ui.select label="Status" name="status" :options="\App\Enums\Status::options()" :selected="$coupon?->status?->value ?? 'active'" required />
                <x-ui.checkbox label="Featured" name="featured" :checked="$coupon?->featured ?? false" />
                <x-ui.checkbox label="Verified" name="verified" hint="Manually confirmed working by an admin." :checked="$coupon?->verified ?? false" />
                <x-ui.checkbox label="Exclusive" name="exclusive" :checked="$coupon?->exclusive ?? false" />
                <x-ui.input label="Sort Order" name="sort_order" type="number" min="0" :value="$coupon?->sort_order ?? 0" />
            </div>
        </x-ui.panel>

        <x-ui.button type="submit" class="w-full justify-center">{{ $coupon ? 'Update Coupon' : 'Create Coupon' }}</x-ui.button>
    </div>
</div>
