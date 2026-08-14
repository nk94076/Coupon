@props(['variant' => 'info'])
@php
    $styles = [
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-200',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    ][$variant] ?? 'bg-slate-50 text-slate-800 border-slate-200';
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 rounded-lg border px-4 py-3 text-sm $styles"]) }} x-data="{ show: true }" x-show="show">
    <div class="flex-1">{{ $slot }}</div>
    <button type="button" @click="show = false" class="shrink-0 text-current opacity-60 hover:opacity-100" aria-label="Dismiss">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>
</div>
