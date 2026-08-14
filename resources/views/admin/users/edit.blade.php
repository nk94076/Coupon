<x-admin-layout title="Edit Admin User">
    <x-ui.page-header title="Edit Admin User" :description="$user->name">
        <x-slot:actions>
            <x-ui.button variant="secondary" :href="route('admin.users.index')">Back to Admin Users</x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div>
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('admin.users._form')
            </form>
        </div>

        <div>
            <x-ui.panel title="Reset Password" description="Set a new password for this admin.">
                <form method="PUT" action="{{ route('admin.users.reset-password', $user) }}" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <x-ui.input label="New Password" name="password" type="password" required />
                    <x-ui.input label="Confirm New Password" name="password_confirmation" type="password" required />
                    <x-ui.button type="submit" variant="secondary">Reset Password</x-ui.button>
                </form>
            </x-ui.panel>
        </div>
    </div>
</x-admin-layout>
