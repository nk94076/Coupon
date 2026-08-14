<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['admin_user_id', 'action', 'module', 'record_id', 'description', 'ip_address', 'user_agent'])]
class ActivityLog extends Model
{
    public $timestamps = true;

    const UPDATED_AT = null;

    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, fn ($q) => $q->where('description', 'like', "%{$term}%"));
    }
}
