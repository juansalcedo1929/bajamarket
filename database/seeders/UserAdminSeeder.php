<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador Baja Market',
            'email' => 'admin@bajamarket.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        echo "✅ Usuario administrador creado\n";
        echo "   Email: admin@bajamarket.com\n";
        echo "   Contraseña: admin123\n";
    }
}