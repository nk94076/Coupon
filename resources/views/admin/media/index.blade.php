<x-admin-layout title="Media Library">
    <x-ui.page-header title="Media Library" description="Upload and reuse images across stores, categories and coupons." />

    <x-ui.panel title="Upload New File" class="mb-6">
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="flex flex-col items-start gap-4 sm:flex-row sm:items-end">
            @csrf
            <div class="w-full sm:max-w-sm">
                <label class="mb-1.5 block text-sm font-medium text-slate-700">File</label>
                <input type="file" name="file" required accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP, up to {{ number_format(config('media.max_size_kb') / 1024, 1) }} MB.</p>
                @error('file')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <x-ui.button type="submit">Upload</x-ui.button>
        </form>
    </x-ui.panel>

    @if ($media->isEmpty())
        <x-ui.empty-state title="No media yet" description="Files you upload here can be reused for SEO images and future content." />
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            @foreach ($media as $item)
                <div class="group relative overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm" x-data="{ copied: false }">
                    <img src="{{ media_url($item->path) }}" alt="{{ $item->original_name }}" class="h-32 w-full object-cover">
                    <div class="p-2">
                        <p class="truncate text-xs font-medium text-slate-700" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                        <p class="text-xs text-slate-400">{{ number_format($item->size / 1024, 0) }} KB</p>
                    </div>
                    <div class="absolute inset-x-0 top-0 flex justify-end gap-1 bg-gradient-to-b from-black/50 to-transparent p-1.5 opacity-0 transition-opacity group-hover:opacity-100">
                        <button
                            type="button"
                            @click="navigator.clipboard.writeText('{{ media_url($item->path) }}'); copied = true; setTimeout(() => copied = false, 1500)"
                            class="rounded bg-white/90 px-2 py-1 text-xs font-medium text-slate-700 hover:bg-white"
                        >
                            <span x-show="!copied">Copy URL</span>
                            <span x-show="copied" x-cloak>Copied!</span>
                        </button>
                        <x-ui.confirm-form
                            :action="route('admin.media.destroy', $item)"
                            label="Delete"
                            size="sm"
                            title="Delete this file?"
                            message="This cannot be undone. Make sure nothing still references it."
                        />
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $media->links() }}</div>
    @endif
</x-admin-layout>
