<x-admin-layout title="Activity Logs">
    <x-ui.page-header title="Activity Logs" description="Audit trail of important admin actions." />

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <x-ui.input name="search" label="Search" placeholder="Search description…" :value="request('search')" />
        <x-ui.select name="admin_user_id" label="Admin" :options="$admins->pluck('name', 'id')" :selected="request('admin_user_id')" placeholder="All admins" />
        <x-ui.select name="module" label="Module" :options="$modules->combine($modules)" :selected="request('module')" placeholder="All modules" />
        <x-ui.select name="action" label="Action" :options="$actions->combine($actions)" :selected="request('action')" placeholder="All actions" />
        <x-ui.input name="date" label="Date" type="date" :value="request('date')" />
        <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-5">
            <x-ui.button type="submit" variant="secondary">Filter</x-ui.button>
            @if (request()->anyFilled(['search', 'admin_user_id', 'module', 'action', 'date']))
                <x-ui.button variant="ghost" :href="route('admin.activity-logs.index')">Reset</x-ui.button>
            @endif
        </div>
    </form>

    @if ($logs->isEmpty())
        <x-ui.empty-state title="No activity yet" description="Admin actions will show up here as they happen." />
    @else
        <x-ui.table :headers="['Admin', 'Action', 'Module', 'Description', 'IP Address', 'When']">
            @foreach ($logs as $log)
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $log->admin?->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-3"><x-ui.badge variant="indigo">{{ ucfirst($log->action) }}</x-ui.badge></td>
                    <td class="px-4 py-3 text-slate-500">{{ ucfirst(str_replace('_', ' ', $log->module)) }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $log->description }}</td>
                    <td class="px-4 py-3 text-slate-400">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500" title="{{ $log->created_at }}">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </x-ui.table>

        <div class="mt-4">{{ $logs->links() }}</div>
    @endif
</x-admin-layout>
