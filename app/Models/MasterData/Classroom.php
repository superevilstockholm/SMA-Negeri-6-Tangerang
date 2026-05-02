<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Models
use App\Models\MasterData\Teacher;

#[Fillable(['name', 'homeroom_teacher_id'])]
class Classroom extends Model
{
    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }
}
