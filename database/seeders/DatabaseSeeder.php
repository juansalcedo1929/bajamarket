<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MunicipioSeeder::class,
            CategoriaSeeder::class,
            UserAdminSeeder::class,
            ProductoSeeder::class,
            ProductorSeeder::class,
        ]);
        
        echo "\n✅ ¡Base de datos poblada exitosamente!\n";
    }
}