<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si el usuario ya existe para evitar duplicados
        if (!Usuario::where('correo', 'admin@bytequest.com')->exists()) {
            Usuario::create([
                'nombre' => 'Admin',
                'apellido' => 'ByteQuest',
                'correo' => 'admin@bytequest.com',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
