<x-admin-layout title="Add Store">
    <x-ui.page-header title="Add Store" description="Create a new store.">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.stores.index')">Back to Stores</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.stores.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.stores._form')
    </form>
</x-admin-layout>
