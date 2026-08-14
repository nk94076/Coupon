@props(['action', 'active' => false, 'onLabel' => 'Active', 'offLabel' => 'Inactive'])

<form method="POST" action="{{ $action }}">
    @csrf
    @method('PATCH')
    <button
        type="submit"
        {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium transition-colors ' . ($active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200')]) }}
    >
        {{ $active ? $onLabel : $offLabel }}
    </button>
</form>
