<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'slug', 'description'])]
class Group extends Model
{
    protected $table = 'gallery_groups';
}
