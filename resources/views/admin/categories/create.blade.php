<x-admin-layout title="Add Category">
    <x-ui.page-header title="Add Category" description="Create a new store category.">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.categories.index')">Back to Categories</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.categories._form')
    </form>
</x-admin-layout>
