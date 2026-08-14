@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ? $title.' — ' : '' }}{{ setting('site_name', config('app.name')) }} Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen flex-col items-center justify-center bg-slate-100 px-4 py-8">
        <div class="mb-6 flex items-center gap-2 text-lg font-semibold text-slate-900">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">CM</span>
            {{ setting('site_name', 'Coupon CMS') }}
        </div>

        <div class="w-full max-w-sm rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <x-ui.flash />
            {{ $slot }}
        </div>
    </div>
</body>
</html>
