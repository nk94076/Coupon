@props(['label' => null, 'name', 'options' => [], 'selected' => null, 'required' => false, 'placeholder' => null])
@php $errorKey = str_replace(['[', ']'], ['.', ''], $name); @endphp

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-slate-700">
            {{ $label }} @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500 ' . ($errors->has($errorKey) ? 'border-red-400' : '')]) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) old($errorKey, $selected) === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @error($errorKey)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
