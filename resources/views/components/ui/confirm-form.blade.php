@props([
    'action',
    'method' => 'DELETE',
    'label' => 'Delete',
    'variant' => 'danger',
    'title' => 'Are you sure?',
    'message' => 'This action cannot be undone.',
    'confirmLabel' => 'Confirm',
])

<div x-data="{ open: false }" class="inline-block">
    <x-ui.button type="button" variant="{{ $variant }}" size="sm" @click="open = true" {{ $attributes }}>
        {{ $label }}
    </x-ui.button>

    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-slate-900/50"></div>

        <div x-show="open" x-transition class="relative w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">
            <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
            <p class="mt-2 text-sm text-slate-500">{{ $message }}</p>

            <div class="mt-6 flex justify-end gap-3">
                <x-ui.button type="button" variant="secondary" size="sm" @click="open = false">Cancel</x-ui.button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    <x-ui.button type="submit" variant="{{ $variant }}" size="sm">{{ $confirmLabel }}</x-ui.button>
                </form>
            </div>
        </div>
    </div>
</div>
