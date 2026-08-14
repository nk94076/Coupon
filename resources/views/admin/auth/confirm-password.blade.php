<x-admin-guest-layout title="Confirm Password">
    <h1 class="mb-2 text-center text-lg font-semibold text-slate-900">Confirm Password</h1>
    <p class="mb-6 text-center text-sm text-slate-500">
        This is a secure area. Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('admin.password.confirm') }}" class="space-y-5">
        @csrf

        <x-ui.input label="Password" name="password" type="password" required autofocus autocomplete="current-password" />

        <x-ui.button type="submit" class="w-full justify-center">Confirm</x-ui.button>
    </form>
</x-admin-guest-layout>
