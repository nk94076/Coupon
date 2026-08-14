<x-admin-layout title="Stores">
    <x-ui.page-header title="Stores" description="Manage the stores coupons are attached to.">
        <x-slot:actions>
            <x-ui.button :href="route('admin.stores.create')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Add Store
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="GET" class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:flex-wrap">
        <div class="flex-1 min-w-[10rem]">
            <x-ui.input name="search" label="Search" placeholder="Search by name…" :value="request('search')" />
        </div>
        <div class="w-full sm:w-48">
            <x-ui.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :selected="request('category_id')" placeholder="All categories" />
        </div>
        <div class="w-full sm:w-40">
            <x-ui.select name="status" label="Status" :options="\App\Enums\Status::options()" :selected="request('status')" placeholder="All statuses" />
        </div>
        <div class="w-full sm:w-40">
            <x-ui.select name="featured" label="Featured" :options="['1' => 'Featured', '0' => 'Not Featured']" :selected="request('featured')" placeholder="All" />
        </div>
        <x-ui.button type="submit" variant="secondary">Filter</x-ui.button>
        @if (request()->anyFilled(['search', 'category_id', 'status', 'featured']))
            <x-ui.button variant="ghost" :href="route('admin.stores.index')">Reset</x-ui.button>
        @endif
    </form>

    @if ($stores->isEmpty())
        <x-ui.empty-state title="No stores yet" description="Add your first store to start attaching coupons to it.">
            <x-slot:action>
                <x-ui.button :href="route('admin.stores.create')">Add Store</x-ui.button>
            </x-slot:action>
        </x-ui.empty-state>
    @else
        <x-ui.table :headers="['Logo', 'Store Name', 'Category', 'Coupons', 'Status', 'Featured', 'Sort', 'Created', 'Actions']">
            @foreach ($stores as $store)
                <tr>
                    <td class="px-4 py-3">
                        @if ($store->logo)
                            <img src="{{ media_url($store->logo) }}" class="h-9 w-9 rounded-lg border border-slate-200 bg-white object-contain p-0.5" alt="">
                        @else
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-xs font-semibold text-slate-400">{{ mb_substr($store->name, 0, 1) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $store->name }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $store->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $store->coupons_count }}</td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.stores.toggle-status', $store)" :active="$store->status->value === 'active'" onLabel="Active" offLabel="Inactive" />
                    </td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.stores.toggle-featured', $store)" :active="$store->featured" onLabel="Featured" offLabel="No" />
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $store->sort_order }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $store->created_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-ui.button size="sm" variant="secondary" :href="route('admin.stores.edit', $store)">Edit</x-ui.button>
                            <x-ui.confirm-form
                                :action="route('admin.stores.destroy', $store)"
                                label="Delete"
                                size="sm"
                                title="Delete this store?"
                                :message="'This will soft-delete “'.$store->name.'”.'"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-ui.table>

        <div class="mt-4">{{ $stores->links() }}</div>
    @endif
</x-admin-layout>
