<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Municipio;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function show(Producto $producto, Request $request)
    {
        // Incrementar contador de vistas
        $producto->increment('vistas');
        
        // Cargar relaciones
        $producto->load('categoria');
        
        // Obtener productores aprobados que ofertan este producto
        $productores = $producto->productoresAprobados()
            ->with('municipio')
            ->when($request->municipio, function($query, $municipio) {
                return $query->where('municipio_id', $municipio);
            })
            ->get();
            
        // Obtener todos los municipios para el filtro
        $municipios = Municipio::activos()->orderBy('nombre')->get();
        
        // Productos relacionados (misma categoría)
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->disponibles()
            ->take(4)
            ->get();

        return view('producto.show', compact('producto', 'productores', 'municipios', 'relacionados'));
    }
}