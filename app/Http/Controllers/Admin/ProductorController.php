<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Productor;
use App\Models\Municipio;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductorController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pendiente');
        
        $productores = Productor::with(['municipio', 'productos'])
            ->when($status, function($query, $status) {
                return $query->where('estatus', $status);
            })
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nombre_empresa', 'like', "%{$search}%")
                      ->orWhere('nombre_contacto', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);
            
        $pendientes = Productor::pendientes()->count();
        $aprobados = Productor::aprobados()->count();
        $rechazados = Productor::where('estatus', 'rechazado')->count();

        return view('admin.productores.index', compact(
            'productores', 
            'status', 
            'pendientes', 
            'aprobados', 
            'rechazados'
        ));
    }

    public function show(Productor $productor)
    {
        $productor->load(['municipio', 'productos.categoria']);
        
        return view('admin.productores.show', compact('productor'));
    }

    public function edit(Productor $productor)
    {
        $municipios = Municipio::activos()->orderBy('nombre')->get();
        $productos = Producto::disponibles()->orderBy('nombre')->get();
        $productor->load('productos');
        
        return view('admin.productores.edit', compact('productor', 'municipios', 'productos'));
    }

public function update(Request $request, Productor $productor)
{
    $validated = $request->validate([
        'nombre_empresa' => 'required|string|max:200',
        'nombre_contacto' => 'required|string|max:200',
        'email' => 'required|email|max:200',
        'telefono_principal' => 'required|string|max:20',
        'telefono_secundario' => 'nullable|string|max:20',
        'whatsapp' => 'nullable|string|max:20',
        'sitio_web' => 'nullable|url|max:200',
        'direccion' => 'required|string',
        'municipio_id' => 'required|exists:municipios,id',
        'descripcion' => 'nullable|string',
        'productos' => 'required|array|min:1',
        'destacado' => 'boolean',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ← AGREGAR ESTA LÍNEA
    ]);

    // Procesar el logo si se subió uno nuevo
    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $fileName = 'productor_' . $productor->id . '_' . time() . '.' . $extension;
        $path = $file->storeAs('productores', $fileName, 'public');
        $validated['logo'] = $path;
    }

    $productor->update($validated);
    $productor->productos()->sync($request->productos);

    return redirect()->route('admin.productores.index')
        ->with('success', 'Productor actualizado correctamente.');
}
    public function aprobar(Productor $productor)
    {
        $productor->update([
            'estatus' => 'aprobado',
            'aprobado_en' => now(),
            'aprobado_por' => Auth::id(),
            'motivo_rechazo' => null,
        ]);

        return redirect()->back()
            ->with('success', 'Productor aprobado correctamente.');
    }

    public function rechazar(Request $request, Productor $productor)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $productor->update([
            'estatus' => 'rechazado',
            'motivo_rechazo' => $request->motivo_rechazo,
        ]);

        return redirect()->back()
            ->with('success', 'Productor rechazado.');
    }

    public function destroy(Productor $productor)
    {
        $productor->delete();
        
        return redirect()->route('admin.productores.index')
            ->with('success', 'Productor eliminado correctamente.');
    }
}