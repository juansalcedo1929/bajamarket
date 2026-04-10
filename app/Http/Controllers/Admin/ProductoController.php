<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::with('categoria')
            ->when($request->search, function($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->when($request->categoria, function($query, $categoria) {
                return $query->where('categoria_id', $categoria);
            })
            ->orderBy('nombre')
            ->paginate(15);
            
        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::activas()->orderBy('nombre')->get();
        
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:200|unique:productos',
            'descripcion' => 'required|string',
            'contenido' => 'nullable|string',
            'temporada' => 'nullable|string|max:100',
            'unidad_medida' => 'nullable|string|max:50',
            'imagen_principal' => 'required|image|max:2048',
            'destacado' => 'boolean',
            'disponible' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        
        if ($request->hasFile('imagen_principal')) {
            $validated['imagen_principal'] = $request->file('imagen_principal')
                ->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::activas()->orderBy('nombre')->get();
        
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:200|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'required|string',
            'contenido' => 'nullable|string',
            'temporada' => 'nullable|string|max:100',
            'unidad_medida' => 'nullable|string|max:50',
            'imagen_principal' => 'nullable|image|max:2048',
            'destacado' => 'boolean',
            'disponible' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        
        if ($request->hasFile('imagen_principal')) {
            $validated['imagen_principal'] = $request->file('imagen_principal')
                ->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}