<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')
            ->orderBy('orden')
            ->get();
            
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias',
            'descripcion' => 'nullable|string',
            'color' => 'required|string|max:20',
            'icono' => 'nullable|image|max:1024',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'integer',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        
        if ($request->hasFile('icono')) {
            $validated['icono'] = $request->file('icono')->store('categorias/iconos', 'public');
        }
        
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        Categoria::create($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'color' => 'required|string|max:20',
            'icono' => 'nullable|image|max:1024',
            'imagen' => 'nullable|image|max:2048',
            'orden' => 'integer',
            'destacado' => 'boolean',
            'activo' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        
        if ($request->hasFile('icono')) {
            $validated['icono'] = $request->file('icono')->store('categorias/iconos', 'public');
        }
        
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        $categoria->update($validated);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }
        
        $categoria->delete();
        
        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}