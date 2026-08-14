<x-admin-layout title="Coupons">
    <x-ui.page-header title="Coupons" description="Manage coupon codes and deals.">
        <x-slot:actions>
            <x-ui.button :href="route('admin.coupons.create')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Add Coupon
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
        <x-ui.input name="search" label="Search" placeholder="Title or code…" :value="request('search')" />
        <x-ui.select name="store_id" label="Store" :options="$stores->pluck('name', 'id')" :selected="request('store_id')" placeholder="All stores" />
        <x-ui.select name="category_id" label="Category" :options="$categories->pluck('name', 'id')" :selected="request('category_id')" placeholder="All categories" />
        <x-ui.select name="coupon_type" label="Coupon Type" :options="\App\Enums\CouponType::options()" :selected="request('coupon_type')" placeholder="All types" />
        <x-ui.select name="status" label="Status" :options="\App\Enums\Status::options()" :selected="request('status')" placeholder="All statuses" />
        <x-ui.select name="verified" label="Verified" :options="['1' => 'Verified', '0' => 'Unverified']" :selected="request('verified')" placeholder="All" />
        <x-ui.select name="featured" label="Featured" :options="['1' => 'Featured', '0' => 'Not Featured']" :selected="request('featured')" placeholder="All" />
        <x-ui.select name="exclusive" label="Exclusive" :options="['1' => 'Exclusive', '0' => 'Not Exclusive']" :selected="request('exclusive')" placeholder="All" />
        <x-ui.select name="expired" label="Expired" :options="['1' => 'Expired', '0' => 'Not Expired']" :selected="request('expired')" placeholder="All" />
        <div class="flex items-end gap-2">
            <x-ui.button type="submit" variant="secondary">Filter</x-ui.button>
            @if (request()->anyFilled(['search', 'store_id', 'category_id', 'coupon_type', 'status', 'verified', 'featured', 'exclusive', 'expired']))
                <x-ui.button variant="ghost" :href="route('admin.coupons.index')">Reset</x-ui.button>
            @endif
        </div>
    </form>

    @if ($coupons->isEmpty())
        <x-ui.empty-state title="No coupons yet" description="Add your first coupon to get started.">
            <x-slot:action>
                <x-ui.button :href="route('admin.coupons.create')">Add Coupon</x-ui.button>
            </x-slot:action>
        </x-ui.empty-state>
    @else
        <x-ui.table :headers="['Store', 'Coupon Title', 'Code', 'Discount', 'Type', 'Expiry', 'Verified', 'Featured', 'Exclusive', 'Status', 'Created', 'Actions']">
            @foreach ($coupons as $coupon)
                @php
                    $discountLabel = match ($coupon->discount_type->value) {
                        'percentage' => $coupon->discount_value ? rtrim(rtrim($coupon->discount_value, '0'), '.').'% off' : '—',
                        'flat' => $coupon->discount_value ? number_format($coupon->discount_value, 2).' off' : '—',
                        'free_shipping' => 'Free Shipping',
                        'cashback' => $coupon->discount_value ? rtrim(rtrim($coupon->discount_value, '0'), '.').'% cashback' : 'Cashback',
                        'buy_one_get_one' => 'BOGO',
                        default => $coupon->discount_value ? $coupon->discount_value : '—',
                    };
                @endphp
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $coupon->store->name }}</td>
                    <td class="px-4 py-3 text-slate-700">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="hover:text-indigo-600">{{ $coupon->title }}</a>
                        @if ($coupon->is_expired)
                            <x-ui.badge variant="red" class="ml-1">Expired</x-ui.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if ($coupon->code)
                            <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs font-semibold text-slate-700">{{ $coupon->code }}</code>
                        @else
                            <span class="text-slate-400">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $discountLabel }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $coupon->coupon_type->label() }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $coupon->expiry_date?->format('M j, Y') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.coupons.toggle-verified', $coupon)" :active="$coupon->verified" onLabel="Verified" offLabel="Unverified" />
                    </td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.coupons.toggle-featured', $coupon)" :active="$coupon->featured" onLabel="Featured" offLabel="No" />
                    </td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.coupons.toggle-exclusive', $coupon)" :active="$coupon->exclusive" onLabel="Exclusive" offLabel="No" />
                    </td>
                    <td class="px-4 py-3">
                        <x-ui.toggle-form :action="route('admin.coupons.toggle-status', $coupon)" :active="$coupon->status->value === 'active'" onLabel="Active" offLabel="Inactive" />
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $coupon->created_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-ui.button size="sm" variant="secondary" :href="route('admin.coupons.edit', $coupon)">Edit</x-ui.button>
                            <x-ui.confirm-form
                                :action="route('admin.coupons.destroy', $coupon)"
                                label="Delete"
                                size="sm"
                                title="Delete this coupon?"
                                :message="'This will soft-delete “'.$coupon->title.'”.'"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-ui.table>

        <div class="mt-4">{{ $coupons->links() }}</div>
    @endif
</x-admin-layout>
