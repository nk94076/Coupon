<?php

namespace App\Models;

use App\Enums\Status;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'parent_id', 'name', 'slug', 'description', 'image', 'status', 'featured', 'sort_order',
    'meta_title', 'meta_description', 'canonical_url', 'robots_index', 'robots_follow',
])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'featured' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::Active);
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, fn ($q) => $q->where('name', 'like', "%{$term}%"));
    }
}
