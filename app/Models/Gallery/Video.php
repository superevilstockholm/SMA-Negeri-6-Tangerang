<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Models
use App\Models\Gallery\Group;

#[Fillable(['thumbnail_path', 'file_path', 'group_id'])]
#[Appends(['thumbnail_url', 'file_url'])]
class Video extends Model
{
    protected $table = 'gallery_videos';

    public function getThumbnailUrlAttribute(): string
    {
        /** @disregard */
        return $this->thumbnail_path
            ? Storage::disk('public')->url($this->thumbnail_path)
            : asset('static/img/no-image-palceholder.svg');
    }

    public function getFileUrlAttribute(): string
    {
        /** @disregard */
        return Storage::disk('public')->url($this->file_path);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
