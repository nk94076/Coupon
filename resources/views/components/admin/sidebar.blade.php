@php
    $admin = auth('admin')->user();

    $items = [
        ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'admin.stores.index', 'active' => 'admin.stores.*', 'label' => 'Stores', 'icon' => 'store'],
        ['route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'label' => 'Categories', 'icon' => 'tag'],
        ['route' => 'admin.coupons.index', 'active' => 'admin.coupons.*', 'label' => 'Coupons', 'icon' => 'ticket'],
        ['route' => 'admin.media.index', 'active' => 'admin.media.*', 'label' => 'Media', 'icon' => 'photo'],
    ];

    if ($admin?->isSuperAdmin()) {
        $items[] = ['route' => 'admin.users.index', 'active' => 'admin.users.*', 'label' => 'Admin Users', 'icon' => 'users'];
    }

    $items[] = ['route' => 'admin.activity-logs.index', 'active' => 'admin.activity-logs.*', 'label' => 'Activity Logs', 'icon' => 'clock'];

    if ($admin?->isSuperAdmin()) {
        $items[] = ['route' => 'admin.settings.edit', 'active' => 'admin.settings.*', 'label' => 'Settings', 'icon' => 'cog'];
    }

    $icons = [
        'home' => 'M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10',
        'store' => 'M3 9l1.5-5h15L21 9M3 9v10a1 1 0 001 1h16a1 1 0 001-1V9M3 9h18M9 21V13h6v8',
        'tag' => 'M7 7h.01M3 11l8-8h6a2 2 0 012 2v6l-8 8a2 2 0 01-2.83 0l-5.17-5.17a2 2 0 010-2.83z',
        'ticket' => 'M9 5H5a2 2 0 00-2 2v2a2 2 0 010 4v2a2 2 0 002 2h4m0-12h10a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H9m0-12v12',
        'photo' => 'M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM3 16l5-5 4 4 5-6 4 5',
        'users' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-3.13a4 4 0 100-8 4 4 0 000 8zm6 0a4 4 0 100-8',
        'clock' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'cog' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
    ];
@endphp

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" aria-hidden="true"></div>

<aside
    class="fixed inset-y-0 left-0 z-40 flex flex-col bg-slate-900 text-slate-200 transition-all duration-200 lg:translate-x-0"
    :class="[sidebarCollapsed ? 'w-20' : 'w-64', sidebarOpen ? 'translate-x-0' : '-translate-x-full']"
>
    <div class="flex h-16 shrink-0 items-center justify-between px-4">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 overflow-hidden font-semibold text-white">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-500 text-sm font-bold">CM</span>
            <span x-show="!sidebarCollapsed" x-cloak class="truncate">{{ setting('site_name', 'Coupon CMS') }}</span>
        </a>
        <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white lg:hidden" aria-label="Close sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @foreach ($items as $item)
            <a
                href="{{ route($item['route']) }}"
                title="{{ $item['label'] }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs($item['active']) ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak class="truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="hidden shrink-0 border-t border-slate-800 p-3 lg:block">
        <button @click="sidebarCollapsed = !sidebarCollapsed" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-400 hover:bg-slate-800 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 transition-transform" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <span x-show="!sidebarCollapsed" x-cloak>Collapse</span>
        </button>
    </div>
</aside>
