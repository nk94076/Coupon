@props(['label', 'value', 'icon' => 'chart', 'variant' => 'indigo'])
@php
    $styles = [
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'green' => 'bg-emerald-50 text-emerald-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'slate' => 'bg-slate-100 text-slate-600',
    ][$variant] ?? 'bg-indigo-50 text-indigo-600';

    $icons = [
        'store' => 'M3 9l1.5-5h15L21 9M3 9v10a1 1 0 001 1h16a1 1 0 001-1V9M3 9h18M9 21V13h6v8',
        'tag' => 'M7 7h.01M3 11l8-8h6a2 2 0 012 2v6l-8 8a2 2 0 01-2.83 0l-5.17-5.17a2 2 0 010-2.83z',
        'ticket' => 'M9 5H5a2 2 0 00-2 2v2a2 2 0 010 4v2a2 2 0 002 2h4m0-12h10a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H9m0-12v12',
        'check' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'star' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.977 2.89a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.977-2.89c-.782-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        'clock' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    ][$icon] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
@endphp

<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-center gap-4">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $styles }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons }}" /></svg>
        </span>
        <div class="min-w-0">
            <p class="truncate text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</p>
            <p class="text-2xl font-semibold text-slate-900">{{ $value }}</p>
        </div>
    </div>
</div>
