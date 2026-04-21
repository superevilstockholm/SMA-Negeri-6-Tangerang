<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['content', 'order'])]
class Vision extends Model
{
    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }
}
