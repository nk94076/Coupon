<x-admin-layout title="Admin Users">
    <x-ui.page-header title="Admin Users" description="Manage who has access to this CMS.">
        <x-slot:actions>
            <x-ui.button :href="route('admin.users.create')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Add Admin User
            </x-ui.button>
        </x-slot:actions>
    </x-ui.page-header>

    <form method="GET" class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end">
        <div class="flex-1">
            <x-ui.input name="search" label="Search" placeholder="Search by name or email…" :value="request('search')" />
        </div>
        <div class="w-full sm:w-48">
            <x-ui.select name="role" label="Role" :options="\App\Enums\AdminRole::options()" :selected="request('role')" placeholder="All roles" />
        </div>
        <div class="w-full sm:w-40">
            <x-ui.select name="status" label="Status" :options="\App\Enums\Status::options()" :selected="request('status')" placeholder="All statuses" />
        </div>
        <x-ui.button type="submit" variant="secondary">Filter</x-ui.button>
        @if (request()->anyFilled(['search', 'role', 'status']))
            <x-ui.button variant="ghost" :href="route('admin.users.index')">Reset</x-ui.button>
        @endif
    </form>

    @if ($users->isEmpty())
        <x-ui.empty-state title="No admin users found" />
    @else
        <x-ui.table :headers="['Name', 'Email', 'Role', 'Status', 'Last Login', 'Created', 'Actions']">
            @foreach ($users as $user)
                @php $isSelf = $user->is(auth('admin')->user()); @endphp
                <tr>
                    <td class="px-4 py-3 font-medium text-slate-900">
                        {{ $user->name }}
                        @if ($isSelf)
                            <x-ui.badge variant="indigo" class="ml-1">You</x-ui.badge>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <x-ui.badge :variant="$user->role->value === 'super_admin' ? 'indigo' : 'slate'">{{ $user->role->label() }}</x-ui.badge>
                    </td>
                    <td class="px-4 py-3">
                        @if ($isSelf)
                            <x-ui.badge variant="green">Active</x-ui.badge>
                        @else
                            <x-ui.toggle-form :action="route('admin.users.toggle-status', $user)" :active="$user->status->value === 'active'" onLabel="Active" offLabel="Inactive" />
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-slate-500">{{ $user->created_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <x-ui.button size="sm" variant="secondary" :href="route('admin.users.edit', $user)">Edit</x-ui.button>
                            @unless ($isSelf)
                                <x-ui.confirm-form
                                    :action="route('admin.users.destroy', $user)"
                                    label="Delete"
                                    size="sm"
                                    title="Delete this admin user?"
                                    :message="'This will permanently remove “'.$user->name.'”\'s access.'"
                                />
                            @endunless
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-ui.table>

        <div class="mt-4">{{ $users->links() }}</div>
    @endif
</x-admin-layout>
