<?php

namespace App\Models;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use Carbon\Carbon;
use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'store_id', 'category_id', 'title', 'slug', 'code', 'description',
    'discount_type', 'discount_value', 'minimum_order', 'maximum_discount',
    'start_date', 'expiry_date',
    'coupon_type', 'is_new_user', 'is_app_only', 'is_bank_offer', 'is_student',
    'affiliate_url', 'status', 'featured', 'exclusive', 'verified', 'sort_order',
    'meta_title', 'meta_description', 'canonical_url', 'robots_index', 'robots_follow',
    'og_title', 'og_description', 'og_image',
])]
class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'discount_type' => DiscountType::class,
            'coupon_type' => CouponType::class,
            'discount_value' => 'decimal:2',
            'minimum_order' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'start_date' => 'date',
            'expiry_date' => 'date',
            'is_new_user' => 'boolean',
            'is_app_only' => 'boolean',
            'is_bank_offer' => 'boolean',
            'is_student' => 'boolean',
            'featured' => 'boolean',
            'exclusive' => 'boolean',
            'verified' => 'boolean',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Whether the coupon's expiry date has passed. This is computed on the
     * fly and never mutates `status` — automated expiry handling belongs to
     * a later phase.
     */
    protected function isExpired(): Attribute
    {
        return Attribute::get(fn (): bool => $this->expiry_date !== null
            && Carbon::parse($this->expiry_date)->lt(now()->startOfDay())
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::Active);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')->whereDate('expiry_date', '<', now()->startOfDay());
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')->orWhereDate('expiry_date', '>=', now()->startOfDay());
        });
    }

    public function scopeSearch($query, ?string $term)
    {
        return $query->when($term, fn ($q) => $q->where(function ($sub) use ($term) {
            $sub->where('title', 'like', "%{$term}%")->orWhere('code', 'like', "%{$term}%");
        }));
    }
}
