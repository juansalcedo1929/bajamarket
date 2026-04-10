<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductores = Productor::count();
        $productoresPendientes = Productor::pendientes()->count();
        $productoresAprobados = Productor::aprobados()->count();
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        
        $ultimosProductores = Productor::with('municipio')
            ->latest()
            ->take(5)
            ->get();
            
        $productoresPopulares = Productor::aprobados()
            ->orderBy('vistas', 'desc')
            ->take(5)
            ->get();
            
        $productosPopulares = Producto::orderBy('vistas', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProductores',
            'productoresPendientes',
            'productoresAprobados',
            'totalProductos',
            'totalCategorias',
            'ultimosProductores',
            'productoresPopulares',
            'productosPopulares'
        ));
    }
}