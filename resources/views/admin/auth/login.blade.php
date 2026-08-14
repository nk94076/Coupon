<x-admin-guest-layout title="Log in">
    <h1 class="mb-6 text-center text-lg font-semibold text-slate-900">Admin Login</h1>

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf

        <x-ui.input label="Email" name="email" type="email" required autofocus autocomplete="username" />

        <div>
            <x-ui.input label="Password" name="password" type="password" required autocomplete="current-password" />
            <a href="{{ route('admin.password.request') }}" class="mt-1.5 inline-block text-xs font-medium text-indigo-600 hover:text-indigo-500">
                Forgot your password?
            </a>
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
            Remember me
        </label>

        <x-ui.button type="submit" class="w-full justify-center">Log in</x-ui.button>
    </form>
</x-admin-guest-layout>
