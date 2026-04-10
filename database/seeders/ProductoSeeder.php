<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        // Obtener categorías por nombre
        $categoriaFrutas = Categoria::where('nombre', 'Frutas')->first();
        $categoriaVerduras = Categoria::where('nombre', 'Verduras')->first();
        $categoriaLacteos = Categoria::where('nombre', 'Lácteos')->first();
        $categoriaQuesos = Categoria::where('nombre', 'Quesos')->first();
        $categoriaMiel = Categoria::where('nombre', 'Miel')->first();
        $categoriaVinos = Categoria::where('nombre', 'Vinos')->first();
        $categoriaAceites = Categoria::where('nombre', 'Aceites')->first();

        $productos = [
            // Frutas
            [
                'categoria_id' => $categoriaFrutas->id,
                'nombre' => 'Fresa',
                'descripcion' => 'Fresas frescas cultivadas en San Quintín, reconocidas por su dulzura y tamaño',
                'temporada' => 'Marzo - Julio',
                'unidad_medida' => 'Caja de 5kg',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/fresa.jpg'
            ],
            [
                'categoria_id' => $categoriaFrutas->id,
                'nombre' => 'Dátil Medjool',
                'descripcion' => 'Dátiles Medjool cultivados en el Valle de Mexicali y San Felipe',
                'temporada' => 'Septiembre - Noviembre',
                'unidad_medida' => 'Caja de 2kg',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/datil.jpg'
            ],
            [
                'categoria_id' => $categoriaFrutas->id,
                'nombre' => 'Uva de Mesa',
                'descripcion' => 'Uvas frescas de variedad Flame, Sugarone y Red Globe',
                'temporada' => 'Mayo - Agosto',
                'unidad_medida' => 'Caja de 8kg',
                'destacado' => false,
                'disponible' => true,
                'imagen_principal' => 'productos/uva.jpg'
            ],
            
            // Verduras
            [
                'categoria_id' => $categoriaVerduras->id,
                'nombre' => 'Tomate',
                'descripcion' => 'Tomate saladette y bola de invernadero',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Caja de 10kg',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/tomate.jpg'
            ],
            [
                'categoria_id' => $categoriaVerduras->id,
                'nombre' => 'Cebollín',
                'descripcion' => 'Cebollín fresco del Valle de Mexicali',
                'temporada' => 'Octubre - Abril',
                'unidad_medida' => 'Manojo',
                'destacado' => false,
                'disponible' => true,
                'imagen_principal' => 'productos/cebollin.jpg'
            ],
            [
                'categoria_id' => $categoriaVerduras->id,
                'nombre' => 'Espárrago',
                'descripcion' => 'Espárrago verde fresco de exportación',
                'temporada' => 'Enero - Mayo',
                'unidad_medida' => 'Caja de 5kg',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/esparrago.jpg'
            ],
            
            // Quesos
            [
                'categoria_id' => $categoriaQuesos->id,
                'nombre' => 'Queso Oaxaca',
                'descripcion' => 'Queso Oaxaca artesanal, elaborado con leche de vaca de libre pastoreo',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Pieza de 500g',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/queso-oaxaca.jpg'
            ],
            [
                'categoria_id' => $categoriaQuesos->id,
                'nombre' => 'Queso Cotija',
                'descripcion' => 'Queso Cotija añejo, perfecto para espolvorear',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Pieza de 250g',
                'destacado' => false,
                'disponible' => true,
                'imagen_principal' => 'productos/queso-cotija.jpg'
            ],
            
            // Miel
            [
                'categoria_id' => $categoriaMiel->id,
                'nombre' => 'Miel Multifloral',
                'descripcion' => 'Miel 100% natural de abeja, cosechada en la Ruta del Vino',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Frasco de 500ml',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/miel.jpg'
            ],
            
            // Vinos
            [
                'categoria_id' => $categoriaVinos->id,
                'nombre' => 'Vino Tinto Nebbiolo',
                'descripcion' => 'Vino tinto de la variedad Nebbiolo, Valle de Guadalupe',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Botella 750ml',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/vino-tinto.jpg'
            ],
            [
                'categoria_id' => $categoriaVinos->id,
                'nombre' => 'Vino Blanco Chenin Blanc',
                'descripcion' => 'Vino blanco fresco y afrutado del Valle de Santo Tomás',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Botella 750ml',
                'destacado' => false,
                'disponible' => true,
                'imagen_principal' => 'productos/vino-blanco.jpg'
            ],
            
            // Aceites
            [
                'categoria_id' => $categoriaAceites->id,
                'nombre' => 'Aceite de Oliva Extra Virgen',
                'descripcion' => 'Aceite de oliva prensado en frío, de olivares de Ensenada',
                'temporada' => 'Todo el año',
                'unidad_medida' => 'Botella 500ml',
                'destacado' => true,
                'disponible' => true,
                'imagen_principal' => 'productos/aceite-oliva.jpg'
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
        
        echo "✅ " . count($productos) . " productos de muestra creados\n";
    }
}