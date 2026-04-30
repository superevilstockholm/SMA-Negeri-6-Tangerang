<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Models
use App\Models\Gallery\Group;

#[Fillable(['file_path', 'group_id'])]
#[Appends(['file_url'])]
class Image extends Model
{
    protected $table = 'gallery_images';

    public function getFileUrlAttribute(): string
    {
        /** @disregard */
        return $this->file_path
            ? Storage::disk('public')->url($this->file_path)
            : asset('static/img/no-image-palceholder.svg');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
