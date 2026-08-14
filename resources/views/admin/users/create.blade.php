<x-admin-layout title="Add Admin User">
    <x-ui.page-header title="Add Admin User" description="Create a new CMS administrator.">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.users.index')">Back to Admin Users</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users._form')
    </form>
</x-admin-layout>
