<x-admin-guest-layout title="Reset Password">
    <h1 class="mb-6 text-center text-lg font-semibold text-slate-900">Reset Password</h1>

    <form method="POST" action="{{ route('admin.password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-ui.input label="Email" name="email" type="email" :value="old('email', $request->email)" required autofocus />

        <x-ui.input label="New Password" name="password" type="password" required autocomplete="new-password" />

        <x-ui.input label="Confirm New Password" name="password_confirmation" type="password" required autocomplete="new-password" />

        <x-ui.button type="submit" class="w-full justify-center">Reset Password</x-ui.button>
    </form>
</x-admin-guest-layout>
