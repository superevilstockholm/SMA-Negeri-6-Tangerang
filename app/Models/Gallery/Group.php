<?php

namespace App\Models\Gallery;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'description'])]
class Group extends Model
{
    protected $table = 'gallery_groups';

    protected static function booted(): void
    {
        static::creating(function ($group) {
            $group->slug = self::generateUniqueSlug($group->title);
        });

        static::updating(function ($group) {
            if ($group->isDirty('title')) {
                $group->slug = self::generateUniqueSlug($group->title, $group->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'group';
        $slug = $baseSlug;
        $count = 1;

        while (self::slugExists($slug, $ignoreId)) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return self::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists();
    }
}
