<x-admin-layout title="Edit Store">
    <x-ui.page-header title="Edit Store" :description="$store->name">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.stores.index')">Back to Stores</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.stores.update', $store) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.stores._form')
    </form>
</x-admin-layout>
