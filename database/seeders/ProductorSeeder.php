<?php

namespace Database\Seeders;

use App\Models\Productor;
use App\Models\Municipio;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductorSeeder extends Seeder
{
    public function run()
    {
        // Obtener municipios
        $ensenada = Municipio::where('nombre', 'Ensenada')->first();
        $mexicali = Municipio::where('nombre', 'Mexicali')->first();
        $sanQuintin = Municipio::where('nombre', 'San Quintín')->first();
        $tecate = Municipio::where('nombre', 'Tecate')->first();

        $productores = [
            [
                'municipio_id' => $ensenada->id,
                'nombre_empresa' => 'Agroindustrias del Valle',
                'nombre_contacto' => 'Juan Pérez González',
                'email' => 'contacto@agroindustriasvalle.com',
                'telefono_principal' => '6461234567',
                'whatsapp' => '526461234567',
                'direccion' => 'Km 10 Carretera Ensenada-Tecate',
                'descripcion' => 'Productores de uva de mesa y vinos artesanales con más de 20 años de experiencia',
                'estatus' => 'aprobado',
                'destacado' => true,
            ],
            [
                'municipio_id' => $sanQuintin->id,
                'nombre_empresa' => 'Fresas San Quintín',
                'nombre_contacto' => 'María Hernández López',
                'email' => 'ventas@fresassq.com',
                'telefono_principal' => '6161234567',
                'whatsapp' => '526161234567',
                'direccion' => 'Ejido Nuevo Mexicali, San Quintín',
                'descripcion' => 'Especialistas en cultivo de fresa y berries de exportación',
                'estatus' => 'aprobado',
                'destacado' => true,
            ],
            [
                'municipio_id' => $mexicali->id,
                'nombre_empresa' => 'Lácteos La Vaquita',
                'nombre_contacto' => 'Carlos Mendoza Ruiz',
                'email' => 'info@lacteoslavquita.com',
                'telefono_principal' => '6861234567',
                'whatsapp' => '526861234567',
                'direccion' => 'Valle de Mexicali, Ejido Puebla',
                'descripcion' => 'Quesos artesanales elaborados con leche de ganado de libre pastoreo',
                'estatus' => 'aprobado',
                'destacado' => false,
            ],
            [
                'municipio_id' => $ensenada->id,
                'nombre_empresa' => 'Aceites Olivares del Mar',
                'nombre_contacto' => 'Ana María Torres',
                'email' => 'hola@olivaresdelmar.com',
                'telefono_principal' => '6469876543',
                'whatsapp' => '526469876543',
                'direccion' => 'Carretera Transpeninsular Km 45',
                'descripcion' => 'Aceite de oliva extra virgen prensado en frío',
                'estatus' => 'aprobado',
                'destacado' => true,
            ],
            [
                'municipio_id' => $tecate->id,
                'nombre_empresa' => 'Miel Kumiai',
                'nombre_contacto' => 'Roberto Cota Vega',
                'email' => 'contacto@mielkumiai.com',
                'telefono_principal' => '6651234567',
                'whatsapp' => '526651234567',
                'direccion' => 'Comunidad Kumiai, Tecate',
                'descripcion' => 'Miel orgánica de abeja producida por comunidades indígenas de la región',
                'estatus' => 'pendiente',
                'destacado' => false,
            ],
        ];

        foreach ($productores as $productorData) {
            $productor = Productor::create($productorData);
            
            // Asociar productos a cada productor
            if ($productor->nombre_empresa == 'Agroindustrias del Valle') {
                $uva = Producto::where('nombre', 'Uva de Mesa')->first();
                $vino = Producto::where('nombre', 'Vino Tinto Nebbiolo')->first();
                if ($uva) $productor->productos()->attach($uva->id, ['presentacion' => 'Caja de 8kg', 'organico' => false]);
                if ($vino) $productor->productos()->attach($vino->id, ['presentacion' => 'Botella 750ml', 'organico' => false]);
            }
            
            if ($productor->nombre_empresa == 'Fresas San Quintín') {
                $fresa = Producto::where('nombre', 'Fresa')->first();
                $tomate = Producto::where('nombre', 'Tomate')->first();
                if ($fresa) $productor->productos()->attach($fresa->id, ['presentacion' => 'Caja de 5kg', 'organico' => false]);
                if ($tomate) $productor->productos()->attach($tomate->id, ['presentacion' => 'Caja de 10kg', 'organico' => true]);
            }
            
            if ($productor->nombre_empresa == 'Lácteos La Vaquita') {
                $quesoOaxaca = Producto::where('nombre', 'Queso Oaxaca')->first();
                $quesoCotija = Producto::where('nombre', 'Queso Cotija')->first();
                if ($quesoOaxaca) $productor->productos()->attach($quesoOaxaca->id, ['presentacion' => 'Pieza 500g', 'organico' => true]);
                if ($quesoCotija) $productor->productos()->attach($quesoCotija->id, ['presentacion' => 'Pieza 250g', 'organico' => true]);
            }
            
            if ($productor->nombre_empresa == 'Aceites Olivares del Mar') {
                $aceite = Producto::where('nombre', 'Aceite de Oliva Extra Virgen')->first();
                if ($aceite) $productor->productos()->attach($aceite->id, ['presentacion' => 'Botella 500ml', 'organico' => true]);
            }
            
            if ($productor->nombre_empresa == 'Miel Kumiai') {
                $miel = Producto::where('nombre', 'Miel Multifloral')->first();
                if ($miel) $productor->productos()->attach($miel->id, ['presentacion' => 'Frasco 500ml', 'organico' => true]);
            }
        }
        
        echo "✅ 5 productores de muestra creados (4 aprobados, 1 pendiente)\n";
    }
}