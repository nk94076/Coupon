<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Http\Requests\Admin\ResetAdminPasswordRequest;
use App\Models\AdminUser;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(AdminUser::class, 'user');
    }

    public function index(Request $request): View
    {
        $users = AdminUser::query()
            ->when($request->filled('search'), fn ($q) => $q->where(function ($sub) use ($request) {
                $term = $request->string('search')->toString();
                $sub->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%");
            }))
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->string('role')->toString()))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->orderBy('name')
            ->paginate((int) setting('default_pagination', 15))
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(AdminUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = AdminUser::create($data);

        ActivityLogService::log('create', 'admin_user', $user->id, "Admin created admin user {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    }

    public function edit(AdminUser $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(AdminUserRequest $request, AdminUser $user): RedirectResponse
    {
        $data = $request->validated();

        if ($user->is(Auth::guard('admin')->user()) && $data['status'] !== Status::Active->value) {
            return back()->withInput()->with('error', "You can't deactivate your own account while logged in.");
        }

        $user->update($data);

        ActivityLogService::log('update', 'admin_user', $user->id, "Admin updated admin user {$user->name}");

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy(AdminUser $user): RedirectResponse
    {
        if ($user->is(Auth::guard('admin')->user())) {
            return back()->with('error', "You can't delete your own account while logged in.");
        }

        $name = $user->name;
        $user->delete();

        ActivityLogService::log('delete', 'admin_user', $user->id, "Admin deleted admin user {$name}");

        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully.');
    }

    public function toggleStatus(AdminUser $user): RedirectResponse
    {
        $this->authorize('update', $user);

        if ($user->is(Auth::guard('admin')->user())) {
            return back()->with('error', "You can't deactivate your own account while logged in.");
        }

        $user->status = $user->status === Status::Active ? Status::Inactive : Status::Active;
        $user->save();

        ActivityLogService::log('update', 'admin_user', $user->id, "Admin changed status of admin user {$user->name} to {$user->status->value}");

        return back()->with('success', 'Admin user status updated.');
    }

    public function resetPassword(ResetAdminPasswordRequest $request, AdminUser $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $user->update(['password' => Hash::make($request->validated('password'))]);

        ActivityLogService::log('update', 'admin_user', $user->id, "Admin reset password for admin user {$user->name}");

        return back()->with('success', 'Password reset successfully.');
    }
}
