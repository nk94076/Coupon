<x-admin-layout title="Dashboard">
    <x-ui.page-header title="Dashboard" description="Welcome back, {{ auth('admin')->user()->name }}." />

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-ui.stat-card label="Total Stores" :value="$stats['total_stores']" icon="store" variant="indigo" />
        <x-ui.stat-card label="Active Stores" :value="$stats['active_stores']" icon="store" variant="green" />
        <x-ui.stat-card label="Total Categories" :value="$stats['total_categories']" icon="tag" variant="blue" />
        <x-ui.stat-card label="Total Coupons" :value="$stats['total_coupons']" icon="ticket" variant="indigo" />
        <x-ui.stat-card label="Active Coupons" :value="$stats['active_coupons']" icon="check" variant="green" />
        <x-ui.stat-card label="Expired Coupons" :value="$stats['expired_coupons']" icon="clock" variant="red" />
        <x-ui.stat-card label="Featured Coupons" :value="$stats['featured_coupons']" icon="star" variant="amber" />
    </div>

    <div class="mt-6">
        <x-ui.panel title="Quick Actions">
            <div class="flex flex-wrap gap-3">
                <x-ui.button :href="route('admin.stores.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Add Store
                </x-ui.button>
                <x-ui.button variant="secondary" :href="route('admin.categories.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Add Category
                </x-ui.button>
                <x-ui.button variant="secondary" :href="route('admin.coupons.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Add Coupon
                </x-ui.button>
            </div>
        </x-ui.panel>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
        <x-ui.panel title="Recent Stores" class="xl:col-span-1">
            @forelse ($recentStores as $store)
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0">
                    <div class="min-w-0">
                        <a href="{{ route('admin.stores.edit', $store) }}" class="block truncate text-sm font-medium text-slate-900 hover:text-indigo-600">{{ $store->name }}</a>
                        <p class="truncate text-xs text-slate-500">{{ $store->category?->name ?? 'Uncategorized' }}</p>
                    </div>
                    <x-ui.badge :variant="$store->status->value === 'active' ? 'green' : 'slate'">{{ $store->status->label() }}</x-ui.badge>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">No stores yet.</p>
            @endforelse
        </x-ui.panel>

        <x-ui.panel title="Recent Coupons" class="xl:col-span-1">
            @forelse ($recentCoupons as $coupon)
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0">
                    <div class="min-w-0">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="block truncate text-sm font-medium text-slate-900 hover:text-indigo-600">{{ $coupon->title }}</a>
                        <p class="truncate text-xs text-slate-500">{{ $coupon->store->name }}</p>
                    </div>
                    <x-ui.badge :variant="$coupon->status->value === 'active' ? 'green' : 'slate'">{{ $coupon->status->label() }}</x-ui.badge>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">No coupons yet.</p>
            @endforelse
        </x-ui.panel>

        <x-ui.panel title="Recently Added Categories" class="xl:col-span-1">
            @forelse ($recentCategories as $category)
                <div class="flex items-center justify-between gap-3 border-b border-slate-100 py-3 last:border-0">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="block truncate text-sm font-medium text-slate-900 hover:text-indigo-600">{{ $category->name }}</a>
                    <x-ui.badge :variant="$category->status->value === 'active' ? 'green' : 'slate'">{{ $category->status->label() }}</x-ui.badge>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-500">No categories yet.</p>
            @endforelse
        </x-ui.panel>
    </div>
</x-admin-layout>
