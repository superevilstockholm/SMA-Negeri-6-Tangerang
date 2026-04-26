<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Attributes
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'email', 'phone', 'message', 'read_at'])]
class Contact extends Model
{
    //
}
