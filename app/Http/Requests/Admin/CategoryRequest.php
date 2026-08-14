<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        /** @var Category|null $category */
        $category = $this->route('category');

        return [
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id')->whereNull('deleted_at'),
                Rule::notIn([$category?->id]),
            ],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable', 'string', 'max:255', 'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($category)->withoutTrashed(),
            ],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('media.max_size_kb')],
            'status' => ['required', Rule::enum(Status::class)],
            'featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots_index' => ['sometimes', 'boolean'],
            'robots_follow' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        $data['featured'] = $this->boolean('featured');
        $data['robots_index'] = $this->boolean('robots_index');
        $data['robots_follow'] = $this->boolean('robots_follow');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
