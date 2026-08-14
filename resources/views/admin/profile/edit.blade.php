<x-admin-layout title="Your Profile">
    <x-ui.page-header title="Your Profile" description="Update your account's profile information and password." />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-ui.panel title="Profile Information">
            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <x-ui.input label="Name" name="name" :value="$user->name" required />
                <x-ui.input label="Email" name="email" type="email" :value="$user->email" required />

                <div class="text-sm text-slate-500">
                    Role: <span class="font-medium text-slate-700">{{ $user->role->label() }}</span>
                </div>

                <x-ui.button type="submit">Save</x-ui.button>
            </form>
        </x-ui.panel>

        <x-ui.panel title="Update Password">
            <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <x-ui.input label="Current Password" name="current_password" type="password" autocomplete="current-password" required />
                <x-ui.input label="New Password" name="password" type="password" autocomplete="new-password" required />
                <x-ui.input label="Confirm New Password" name="password_confirmation" type="password" autocomplete="new-password" required />

                <x-ui.button type="submit">Update Password</x-ui.button>
            </form>
        </x-ui.panel>
    </div>
</x-admin-layout>
