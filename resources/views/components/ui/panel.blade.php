@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm']) }}>
    @if ($title)
        <div class="mb-5 border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-slate-900">{{ $title }}</h2>
            @if ($description)
                <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
