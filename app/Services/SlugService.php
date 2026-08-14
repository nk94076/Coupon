<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Generates unique, URL-safe slugs for any Eloquent model.
 *
 * Uniqueness checks intentionally ignore soft-delete scopes (via withTrashed)
 * so a restored/soft-deleted record can never collide with a new one.
 */
class SlugService
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public static function unique(string $modelClass, string $source, ?int $ignoreId = null, string $column = 'slug'): string
    {
        $base = Str::slug($source);

        if ($base === '') {
            $base = Str::lower(Str::random(8));
        }

        $slug = $base;
        $suffix = 2;

        while (static::exists($modelClass, $column, $slug, $ignoreId)) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    protected static function exists(string $modelClass, string $column, string $slug, ?int $ignoreId): bool
    {
        /** @var Model $instance */
        $instance = new $modelClass;

        /** @var Builder $query */
        $query = $instance->query();

        if (method_exists($instance, 'trashed')) {
            $query->withTrashed();
        }

        $query->where($column, $slug);

        if ($ignoreId !== null) {
            $query->where($instance->getKeyName(), '!=', $ignoreId);
        }

        return $query->exists();
    }
}
