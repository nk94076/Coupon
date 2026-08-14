@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' — ' : '' }}{{ setting('site_name', config('app.name')) }} Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900">
    <div class="flex min-h-screen">
        <x-admin.sidebar />

        <div class="flex min-h-screen w-full flex-1 flex-col transition-all duration-200" :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'">
            <x-admin.topbar :title="$title" />

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @isset($header)
                    <div class="mb-6">{{ $header }}</div>
                @endisset

                <x-ui.flash />

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
