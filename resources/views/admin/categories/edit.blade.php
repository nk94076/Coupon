<x-admin-layout title="Edit Category">
    <x-ui.page-header title="Edit Category" :description="$category->name">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.categories.index')">Back to Categories</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
</x-admin-layout>
