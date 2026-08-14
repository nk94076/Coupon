<?php

namespace App\Http\Requests\Admin;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var Coupon|null $coupon */
        $coupon = $this->route('coupon');

        return [
            'store_id' => ['required', Rule::exists('stores', 'id')->whereNull('deleted_at')],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->whereNull('deleted_at')],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable', 'string', 'max:255', 'alpha_dash',
                Rule::unique('coupons', 'slug')->ignore($coupon)->withoutTrashed(),
            ],
            'code' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],

            'discount_type' => ['required', Rule::enum(DiscountType::class)],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'minimum_order' => ['nullable', 'numeric', 'min:0'],
            'maximum_discount' => ['nullable', 'numeric', 'min:0'],

            'start_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:start_date'],

            'coupon_type' => ['required', Rule::enum(CouponType::class)],
            'is_new_user' => ['sometimes', 'boolean'],
            'is_app_only' => ['sometimes', 'boolean'],
            'is_bank_offer' => ['sometimes', 'boolean'],
            'is_student' => ['sometimes', 'boolean'],

            'affiliate_url' => ['nullable', 'url', 'max:255'],

            'status' => ['required', Rule::enum(Status::class)],
            'featured' => ['sometimes', 'boolean'],
            'exclusive' => ['sometimes', 'boolean'],
            'verified' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots_index' => ['sometimes', 'boolean'],
            'robots_follow' => ['sometimes', 'boolean'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('media.max_size_kb')],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        foreach (['is_new_user', 'is_app_only', 'is_bank_offer', 'is_student', 'featured', 'exclusive', 'verified', 'robots_index', 'robots_follow'] as $flag) {
            $data[$flag] = $this->boolean($flag);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
