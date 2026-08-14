@props(['label' => null, 'name', 'checked' => false, 'hint' => null])

<label for="{{ $name }}" class="flex items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50 cursor-pointer">
    <input type="hidden" name="{{ $name }}" value="0">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="1"
        @checked(old($name, $checked))
        {{ $attributes->merge(['class' => 'mt-0.5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500']) }}
    />
    <span>
        <span class="block text-sm font-medium text-slate-700">{{ $label }}</span>
        @if ($hint)
            <span class="block text-xs text-slate-500">{{ $hint }}</span>
        @endif
    </span>
</label>
