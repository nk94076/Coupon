@if (session('success'))
    <x-ui.alert variant="success" class="mb-4">{{ session('success') }}</x-ui.alert>
@endif

@if (session('status'))
    <x-ui.alert variant="success" class="mb-4">{{ session('status') }}</x-ui.alert>
@endif

@if (session('error'))
    <x-ui.alert variant="error" class="mb-4">{{ session('error') }}</x-ui.alert>
@endif

@if ($errors->any())
    <x-ui.alert variant="error" class="mb-4">
        <p class="font-medium">Please fix the following:</p>
        <ul class="mt-1 list-inside list-disc space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif
