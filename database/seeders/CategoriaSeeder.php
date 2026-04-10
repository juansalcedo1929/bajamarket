<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Frutas',
                'descripcion' => 'Frutas frescas cultivadas en los valles de Baja California',
                'color' => '#ef4444',
                'orden' => 1,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Verduras',
                'descripcion' => 'Hortalizas y verduras de la más alta calidad',
                'color' => '#22c55e',
                'orden' => 2,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Lácteos',
                'descripcion' => 'Productos lácteos artesanales de la región',
                'color' => '#3b82f6',
                'orden' => 3,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Quesos',
                'descripcion' => 'Quesos artesanales tipo Oaxaca, Cotija, Fresco y más',
                'color' => '#f59e0b',
                'orden' => 4,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Miel',
                'descripcion' => 'Miel 100% natural de abeja, multifloral y de mezquite',
                'color' => '#eab308',
                'orden' => 5,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Cárnicos',
                'descripcion' => 'Carnes de res, cerdo y ave de productores locales',
                'color' => '#dc2626',
                'orden' => 6,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Vinos',
                'descripcion' => 'Vinos de los Valles de Guadalupe, Santo Tomás y San Vicente',
                'color' => '#8b5cf6',
                'orden' => 7,
                'destacado' => true,
                'activo' => true
            ],
            [
                'nombre' => 'Aceites',
                'descripcion' => 'Aceite de oliva extra virgen y aceites gourmet',
                'color' => '#84cc16',
                'orden' => 8,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Granos',
                'descripcion' => 'Frijoles, maíz, trigo y otros granos de la región',
                'color' => '#d97706',
                'orden' => 9,
                'destacado' => false,
                'activo' => true
            ],
            [
                'nombre' => 'Hierbas',
                'descripcion' => 'Hierbas aromáticas y medicinales orgánicas',
                'color' => '#059669',
                'orden' => 10,
                'destacado' => false,
                'activo' => true
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
        
        echo "✅ 10 categorías de productos creadas\n";
    }
}