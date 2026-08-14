<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with('admin')
            ->search($request->string('search')->toString() ?: null)
            ->when($request->filled('admin_user_id'), fn ($q) => $q->where('admin_user_id', $request->integer('admin_user_id')))
            ->when($request->filled('module'), fn ($q) => $q->where('module', $request->string('module')->toString()))
            ->when($request->filled('action'), fn ($q) => $q->where('action', $request->string('action')->toString()))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('created_at', $request->date('date')))
            ->latest()
            ->paginate((int) setting('default_pagination', 20))
            ->withQueryString();

        $admins = AdminUser::query()->orderBy('name')->get(['id', 'name']);
        $modules = ActivityLog::query()->distinct()->orderBy('module')->pluck('module');
        $actions = ActivityLog::query()->distinct()->orderBy('action')->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'admins', 'modules', 'actions'));
    }
}
