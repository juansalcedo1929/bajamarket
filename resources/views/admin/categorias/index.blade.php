@extends('layouts.admin')

@section('title', 'Gestión de Categorías')
@section('page-title', 'Categorías')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Header -->
    <div class="p-4 border-b flex justify-between items-center">
        <p class="text-gray-600">{{ $categorias->count() }} categorías</p>
        <a href="{{ route('admin.categorias.create') }}" 
           class="px-4 py-2 bg-[#b17a45] text-white rounded-lg hover:bg-[#8a5e35] transition">
            + Nueva Categoría
        </a>
    </div>
    
    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Productos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categorias as $categoria)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="w-8 h-8 rounded-full" style="background-color: {{ $categoria->color }};"></div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $categoria->nombre }}</p>
                        <p class="text-xs text-gray-500">{{ $categoria->slug }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600">{{ Str::limit($categoria->descripcion, 50) }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $categoria->productos_count }}</td>
                    <td class="px-6 py-4 text-sm">{{ $categoria->orden }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $categoria->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $categoria->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                        @if($categoria->destacado)
                            <span class="ml-1 px-2 py-1 text-xs rounded-full bg-[#b17a45] text-white">
                                Destacada
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('catalogo.categoria', $categoria) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800" title="Ver en sitio">
                                👁️
                            </a>
                            <a href="{{ route('admin.categorias.edit', $categoria) }}" 
                               class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                ✏️
                            </a>
                            <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar"
                                        {{ $categoria->productos_count > 0 ? 'disabled' : '' }}>
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                        No hay categorías registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



