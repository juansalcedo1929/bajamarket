<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::activas()
            ->withCount('productos')
            ->orderBy('orden')
            ->get();
            
        $productos = Producto::with('categoria')
            ->disponibles()
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
                });
            })
            ->when($request->categoria, function($query, $categoria) {
                return $query->where('categoria_id', $categoria);
            })
            ->when($request->temporada, function($query, $temporada) {
                return $query->where('temporada', 'like', "%{$temporada}%");
            })
            ->orderBy('nombre')
            ->paginate(12);
            
        $temporadas = Producto::disponibles()
            ->whereNotNull('temporada')
            ->distinct()
            ->pluck('temporada');

        return view('catalogo.index', compact('categorias', 'productos', 'temporadas'));
    }
    
    public function categoria(Categoria $categoria, Request $request)
    {
        $productos = Producto::where('categoria_id', $categoria->id)
            ->disponibles()
            ->when($request->search, function($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('nombre')
            ->paginate(12);
            
        $categorias = Categoria::activas()->orderBy('orden')->get();

        return view('catalogo.categoria', compact('categoria', 'productos', 'categorias'));
    }
}