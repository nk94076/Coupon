<x-admin-layout title="Categories">
    <x-ui.page-header title="Categories" description="Organize stores and coupons into browsable categories.">
        <x-slot:actions>
            <x-ui.button :href="route('admin.categories.create')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Add Category
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="GET" class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end">
        <div class="flex-1">
            <x-ui.input name="search" label="Search" placeholder="Search by name…" :value="request('search')" />
        </div>
        <div class="w-full sm:w-48">
            <x-ui.select name="parent_id" label="Parent" :options="$parents->pluck('name', 'id')" :selected="request('parent_id')" placeholder="All parents" />
        </div>
        <div class="w-full sm:w-40">
            <x-ui.select name="status" label="Status" :options="\App\Enums\Status::options()" :selected="request('status')" placeholder="All statuses" />
        </div>
        <x-ui.button type="submit" variant="secondary">Filter</x-ui.button>
        @if (request()->anyFilled(['search', 'parent_id', 'status']))
            <x-ui.button variant="ghost" :href="route('admin.categories.index')">Reset</x-ui.button>
        @endif
    </form>

    @if ($categories->isEmpty())
        <x-ui.empty-state title="No categories yet" description="Create your first category to start organizing stores and coupons.">
            <x-slot:action>
                <x-ui.button :href="route('admin.categories.create')">Add Category</x-ui.button>
            </x-slot:action>
        </x-ui.empty-state>
    @else
        <x-ui.table :headers="['Name', 'Parent', 'Stores', 'Status', 'Featured', 'Sort', 'Created', 'Actions']">
            @foreach ($categories as $category)
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-900">
                        <div class="flex items-center gap-3">
                            @if ($category->image)
                                <img src="{{ media_url($category->image) }}" class="h-8 w-8 rounded object-cover" alt="">
                            @endif
                            {{ $category->name }}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $category->parent?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $category->stores_count }}</td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.categories.toggle-status', $category)" :active="$category->status->value === 'active'" onLabel="Active" offLabel="Inactive" />
                    </td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.categories.toggle-featured', $category)" :active="$category->featured" onLabel="Featured" offLabel="No" />
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $category->sort_order }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $category->created_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-ui.button size="sm" variant="secondary" :href="route('admin.categories.edit', $category)">Edit</x-ui.button>
                            <x-ui.confirm-form
                                :action="route('admin.categories.destroy', $category)"
                                label="Delete"
                                size="sm"
                                title="Delete this category?"
                                :message="'This will soft-delete “'.$category->name.'”. Stores/coupons keep their reference until reassigned.'"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-ui.table>

        <div class="mt-4">{{ $categories->links() }}</div>
    @endif
</x-admin-layout>
