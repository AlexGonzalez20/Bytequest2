<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Usuario::firstOrCreate(
            ['correo' => 'admin@bytequest.com'],
            ['password' => Hash::make('12345678')]
        );
    }
}