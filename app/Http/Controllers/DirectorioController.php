<?php

namespace App\Http\Controllers;

use App\Models\Productor;
use App\Models\Municipio;
use App\Models\Producto;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index(Request $request)
    {
        $productores = Productor::aprobados()
            ->with(['municipio', 'productos'])
            ->when($request->search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nombre_empresa', 'like', "%{$search}%")
                      ->orWhere('nombre_contacto', 'like', "%{$search}%")
                      ->orWhere('descripcion', 'like', "%{$search}%");
                });
            })
            ->when($request->municipio, function($query, $municipio) {
                return $query->where('municipio_id', $municipio);
            })
            ->when($request->producto, function($query, $producto) {
                return $query->whereHas('productos', function($q) use ($producto) {
                    $q->where('producto_id', $producto);
                });
            })
            ->orderBy('destacado', 'desc')
            ->orderBy('nombre_empresa')
            ->paginate(12);
            
        $municipios = Municipio::activos()->orderBy('nombre')->get();
        $productos = Producto::disponibles()->orderBy('nombre')->get();

        return view('directorio.index', compact('productores', 'municipios', 'productos'));
    }
    
    public function show(Productor $productor)
    {
        // Solo mostrar si está aprobado
        if ($productor->estatus !== 'aprobado') {
            abort(404);
        }
        
        $productor->increment('vistas');
        $productor->load(['municipio', 'productos' => function($query) {
            $query->with('categoria')->orderBy('nombre');
        }]);

        return view('directorio.show', compact('productor'));
    }
    
    public function create()
    {
        $municipios = Municipio::activos()->orderBy('nombre')->get();
        $productos = Producto::disponibles()->orderBy('nombre')->get();
        
        return view('directorio.create', compact('municipios', 'productos'));
    }
    
public function store(Request $request)
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
        'colonia' => 'nullable|string|max:100',
        'codigo_postal' => 'nullable|string|max:10',
        'municipio_id' => 'required|exists:municipios,id', // ← VALIDACIÓN OBLIGATORIA
        'descripcion' => 'nullable|string',
        'productos' => 'required|array|min:1',
        'productos.*' => 'exists:productos,id',
        'facebook' => 'nullable|url',
        'instagram' => 'nullable|url',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'municipio_id.required' => 'Debes seleccionar un municipio.',
        'municipio_id.exists' => 'El municipio seleccionado no es válido.',
        'productos.required' => 'Debes seleccionar al menos un producto que ofertas.',
        'productos.min' => 'Debes seleccionar al menos un producto.',
        'logo.image' => 'El archivo debe ser una imagen válida.',
        'logo.mimes' => 'El logo debe ser de tipo: jpeg, png, jpg, gif o webp.',
        'logo.max' => 'El logo no debe pesar más de 2MB.',
    ]);

    try {
        // Crear productor con estatus pendiente
        $productor = Productor::create([
            'nombre_empresa' => $validated['nombre_empresa'],
            'nombre_contacto' => $validated['nombre_contacto'],
            'email' => $validated['email'],
            'telefono_principal' => $validated['telefono_principal'],
            'telefono_secundario' => $validated['telefono_secundario'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'sitio_web' => $validated['sitio_web'] ?? null,
            'direccion' => $validated['direccion'],
            'colonia' => $validated['colonia'] ?? null,
            'codigo_postal' => $validated['codigo_postal'] ?? null,
            'municipio_id' => $validated['municipio_id'], // ← SIEMPRE PRESENTE
            'descripcion' => $validated['descripcion'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'estatus' => 'pendiente',
        ]);

        // Resto del código...
        
    } catch (\Exception $e) {
        \Log::error('Error al registrar productor: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Ocurrió un error al procesar tu registro. Por favor intenta de nuevo.')
            ->withInput();
    }
}
}