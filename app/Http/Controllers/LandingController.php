<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Productor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $categorias = Categoria::activas()
            ->destacadas()
            ->orderBy('orden')
            ->take(8)
            ->get();
            
        $productosDestacados = Producto::with('categoria')
            ->disponibles()
            ->where('destacado', true)
            ->take(6)
            ->get();
            
        $productoresDestacados = Productor::aprobados()
            ->where('destacado', true)
            ->with('municipio')
            ->take(4)
            ->get();
            
        $totalProductores = Productor::aprobados()->count();
        $totalProductos = Producto::disponibles()->count();
        $totalMunicipios = 7;

        return view('landing', compact(
            'categorias',
            'productosDestacados',
            'productoresDestacados',
            'totalProductores',
            'totalProductos',
            'totalMunicipios'
        ));
    }
}