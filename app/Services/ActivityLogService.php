<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Central logging point for admin activity. Controllers call log() after
 * a create/update/delete/status-change action so every important admin
 * action is auditable.
 */
class ActivityLogService
{
    public static function log(string $action, string $module, ?int $recordId = null, ?string $description = null): ActivityLog
    {
        return ActivityLog::create([
            'admin_user_id' => Auth::guard('admin')->id(),
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 255),
        ]);
    }
}
