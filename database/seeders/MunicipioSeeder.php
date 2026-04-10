<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
    public function run()
    {
        $municipios = [
            [
                'nombre' => 'Ensenada',
                'codigo_postal_prefix' => '22',
                'descripcion' => 'Municipio más grande de México, líder en producción vitivinícola y pesquera',
                'activo' => true
            ],
            [
                'nombre' => 'Mexicali',
                'codigo_postal_prefix' => '21',
                'descripcion' => 'Capital del estado, corazón agrícola del Valle de Mexicali',
                'activo' => true
            ],
            [
                'nombre' => 'Tecate',
                'codigo_postal_prefix' => '21',
                'descripcion' => 'Pueblo Mágico, reconocido por su panadería artesanal y cerveza',
                'activo' => true
            ],
            [
                'nombre' => 'Tijuana',
                'codigo_postal_prefix' => '22',
                'descripcion' => 'Ciudad fronteriza con importante actividad comercial y gastronómica',
                'activo' => true
            ],
            [
                'nombre' => 'Playas de Rosarito',
                'codigo_postal_prefix' => '22',
                'descripcion' => 'Destino turístico costero con creciente producción acuícola',
                'activo' => true
            ],
            [
                'nombre' => 'San Quintín',
                'codigo_postal_prefix' => '22',
                'descripcion' => 'Valle agrícola con importante producción de berries y hortalizas',
                'activo' => true
            ],
            [
                'nombre' => 'San Felipe',
                'codigo_postal_prefix' => '21',
                'descripcion' => 'Puerto pesquero en el Mar de Cortés, creciente producción de dátil',
                'activo' => true
            ],
        ];

        foreach ($municipios as $municipio) {
            Municipio::create($municipio);
        }
        
        echo "✅ 7 municipios de Baja California creados\n";
    }
}