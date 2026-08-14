<x-admin-layout title="Edit Coupon">
    <x-ui.page-header title="Edit Coupon" :description="$coupon->title">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.coupons.index')">Back to Coupons</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.coupons._form')
    </form>
</x-admin-layout>
