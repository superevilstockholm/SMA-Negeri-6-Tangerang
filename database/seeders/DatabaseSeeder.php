<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Models
use App\Models\MasterData\User;

// Enums
use App\Enums\RoleEnum;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First admin user
        User::updateOrCreate([
            'email' => config('admin.email'),
        ], [
            'email' => config('admin.email'),
            'password' => config('admin.password'),
            'role' => RoleEnum::ADMIN,
            'email_verified_at' => now(),
        ]);
    }
}
