<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Enums
use App\Enums\GenderEnum;

// Models
use App\Models\MasterData\User;
use App\Models\MasterData\Classroom;

#[Fillable(['name', 'nip', 'dob', 'gender', 'photo_path', 'user_id'])]
#[Appends(['photo_url'])]
class Teacher extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gender' => GenderEnum::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function homeroomClassroom()
    {
        return $this->hasOne(Classroom::class, 'homeroom_teacher_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        /** @disregard */
        return $this->photo_path
            ? Storage::disk('public')->url($this->photo_path)
            : asset('static/img/no-image-palceholder.svg');
    }
}
