<x-admin-guest-layout title="Forgot Password">
    <h1 class="mb-2 text-center text-lg font-semibold text-slate-900">Forgot Password</h1>
    <p class="mb-6 text-center text-sm text-slate-500">
        Enter your email and we'll send you a password reset link.
    </p>

    <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5">
        @csrf

        <x-ui.input label="Email" name="email" type="email" required autofocus />

        <x-ui.button type="submit" class="w-full justify-center">Email Password Reset Link</x-ui.button>
    </form>

    <p class="mt-6 text-center text-sm">
        <a href="{{ route('admin.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Back to login</a>
    </p>
</x-admin-guest-layout>
