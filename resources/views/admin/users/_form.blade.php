@php $user = $user ?? null; @endphp

<x-ui.panel class="max-w-xl">
    <div class="space-y-5">
        <x-ui.input label="Name" name="name" :value="$user?->name" required />
        <x-ui.input label="Email" name="email" type="email" :value="$user?->email" required />
        <x-ui.select label="Role" name="role" :options="\App\Enums\AdminRole::options()" :selected="$user?->role?->value ?? 'manager'" required />
        <x-ui.select label="Status" name="status" :options="\App\Enums\Status::options()" :selected="$user?->status?->value ?? 'active'" required />

        @unless ($user)
            <x-ui.input label="Password" name="password" type="password" required />
            <x-ui.input label="Confirm Password" name="password_confirmation" type="password" required />
        @endunless
    </div>
</x-ui.panel>

<div class="mt-6">
    <x-ui.button type="submit">{{ $user ? 'Update Admin User' : 'Create Admin User' }}</x-ui.button>
</div>
