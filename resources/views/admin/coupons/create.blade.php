<x-admin-layout title="Add Coupon">
    <x-ui.page-header title="Add Coupon" description="Create a new coupon.">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.coupons.index')">Back to Coupons</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.coupons.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.coupons._form')
    </form>
</x-admin-layout>
