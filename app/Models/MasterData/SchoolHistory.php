<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'description', 'start_year', 'end_year', 'order'])]
class SchoolHistory extends Model
{
    public function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
            'order' => 'integer',
        ];
    }
}
