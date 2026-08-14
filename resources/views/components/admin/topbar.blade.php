@props(['title' => null])

<header class="sticky top-0 z-20 flex h-16 shrink-0 items-center gap-4 border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
    <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 lg:hidden" aria-label="Open sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
    </button>

    @if ($title)
        <h1 class="hidden text-lg font-semibold text-slate-900 sm:block">{{ $title }}</h1>
    @endif

    <div class="ml-auto flex flex-1 items-center justify-end gap-3 sm:flex-none">
        <form action="#" method="GET" class="relative hidden sm:block" onsubmit="return false;">
            <svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
            <input type="search" placeholder="Search…" class="w-56 rounded-lg border border-slate-300 bg-slate-50 py-2 pl-9 pr-3 text-sm focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500" />
        </form>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700" aria-label="Notifications">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .53-.21 1.04-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-72 rounded-lg border border-slate-200 bg-white p-4 text-sm text-slate-500 shadow-lg">
                No notifications yet. This panel is a placeholder for future alerts.
            </div>
        </div>

        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 rounded-full py-1 pl-1 pr-2 hover:bg-slate-100">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">
                    {{ mb_strtoupper(mb_substr(auth('admin')->user()->name ?? '?', 0, 1)) }}
                </span>
                <span class="hidden text-left sm:block">
                    <span class="block text-sm font-medium text-slate-900">{{ auth('admin')->user()->name }}</span>
                    <span class="block text-xs text-slate-500">{{ auth('admin')->user()->role->label() }}</span>
                </span>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Your Profile</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-50">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</header>
