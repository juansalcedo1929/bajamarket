@extends('layouts.admin')

@section('title', 'Gestión de Productos')
@section('page-title', 'Productos')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Header con botón crear -->
    <div class="p-4 border-b flex justify-between items-center">
        <form method="GET" class="flex-1 flex gap-4">
            <input type="text" 
                   name="search" 
                   placeholder="Buscar producto..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
            
            <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2 bg-[#6a1c32] text-white rounded-lg hover:bg-[#993233]">
                Buscar
            </button>
            
            @if(request()->anyFilled(['search', 'categoria']))
                <a href="{{ route('admin.productos.index') }}" 
                   class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Limpiar
                </a>
            @endif
        </form>
        
        <a href="{{ route('admin.productos.create') }}" 
           class="ml-4 px-4 py-2 bg-[#b17a45] text-white rounded-lg hover:bg-[#8a5e35] transition">
            + Nuevo Producto
        </a>
    </div>
    
    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Imagen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temporada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vistas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($productos as $producto)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <img src="{{ $producto->imagen_principal_url }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-12 h-12 object-cover rounded-lg">
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $producto->nombre }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit($producto->descripcion, 40) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full" 
                              style="background-color: {{ $producto->categoria->color }}20; color: {{ $producto->categoria->color }};">
                            {{ $producto->categoria->nombre }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $producto->temporada ?? 'Todo el año' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $producto->disponible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $producto->disponible ? 'Disponible' : 'No disponible' }}
                        </span>
                        @if($producto->destacado)
                            <span class="ml-1 px-2 py-1 text-xs rounded-full bg-[#b17a45] text-white">
                                Destacado
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $producto->vistas }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('producto.show', $producto) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800" title="Ver en sitio">
                                👁️
                            </a>
                            <a href="{{ route('admin.productos.edit', $producto) }}" 
                               class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                ✏️
                            </a>
                            <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este producto?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        No hay productos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="p-4 border-t">
        {{ $productos->appends(request()->query())->links() }}
    </div>
</div>
@endsection



