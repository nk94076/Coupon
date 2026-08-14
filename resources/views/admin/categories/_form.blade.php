@php $category = $category ?? null; @endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <x-ui.panel title="Basic Information">
            <div class="space-y-5">
                <x-ui.select
                    label="Parent Category"
                    name="parent_id"
                    :options="$parents->pluck('name', 'id')"
                    :selected="$category?->parent_id"
                    placeholder="None (top-level category)"
                />

                <x-ui.input label="Category Name" name="name" :value="$category?->name" required />

                <x-ui.input
                    label="Slug"
                    name="slug"
                    :value="$category?->slug"
                    hint="Leave blank to auto-generate from the name. Editing this changes the category's URL."
                />

                <x-ui.textarea label="Description" name="description" :value="$category?->description" />

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Category Image</label>
                    @if ($category?->image)
                        <img src="{{ media_url($category->image) }}" alt="{{ $category->name }}" class="mb-2 h-20 w-20 rounded-lg border border-slate-200 object-cover">
                    @endif
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP, up to {{ number_format(config('media.max_size_kb') / 1024, 1) }} MB.</p>
                    @error('image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </x-ui.panel>

        <x-ui.panel title="SEO" description="These fields feed the full SEO engine coming in a later phase.">
            <div class="space-y-5">
                <x-ui.input label="Meta Title" name="meta_title" :value="$category?->meta_title" />
                <x-ui.textarea label="Meta Description" name="meta_description" :value="$category?->meta_description" :rows="2" />
                <x-ui.input label="Canonical URL" name="canonical_url" type="url" :value="$category?->canonical_url" />
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <x-ui.checkbox label="Index" name="robots_index" hint="Allow search engines to index this page." :checked="$category?->robots_index ?? true" />
                    <x-ui.checkbox label="Follow" name="robots_follow" hint="Allow search engines to follow links." :checked="$category?->robots_follow ?? true" />
                </div>
            </div>
        </x-ui.panel>
    </div>

    <div class="space-y-6">
        <x-ui.panel title="Settings">
            <div class="space-y-5">
                <x-ui.select label="Status" name="status" :options="\App\Enums\Status::options()" :selected="$category?->status?->value ?? 'active'" required />
                <x-ui.checkbox label="Featured" name="featured" hint="Show in featured category lists." :checked="$category?->featured ?? false" />
                <x-ui.input label="Sort Order" name="sort_order" type="number" min="0" :value="$category?->sort_order ?? 0" />
            </div>
        </x-ui.panel>

        <x-ui.button type="submit" class="w-full justify-center">{{ $category ? 'Update Category' : 'Create Category' }}</x-ui.button>
    </div>
</div>
