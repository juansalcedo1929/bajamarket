@extends('layouts.admin')

@section('title', 'Editar Producto')
@section('page-title', 'Editar Producto')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Categoría -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                    <select name="categoria_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nombre -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del producto *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                    <textarea name="descripcion" rows="3" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Contenido adicional -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contenido adicional</label>
                    <textarea name="contenido" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">{{ old('contenido', $producto->contenido) }}</textarea>
                </div>
                
                <!-- Temporada -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Temporada</label>
                    <input type="text" name="temporada" value="{{ old('temporada', $producto->temporada) }}" 
                           placeholder="Ej: Marzo - Julio"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Unidad de medida -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unidad de medida</label>
                    <input type="text" name="unidad_medida" value="{{ old('unidad_medida', $producto->unidad_medida) }}" 
                           placeholder="Ej: Caja de 5kg"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Imagen actual -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen actual</label>
                    <img src="{{ $producto->imagen_principal_url }}" 
                         alt="{{ $producto->nombre }}" 
                         class="w-32 h-32 object-cover rounded-lg mb-3">
                </div>
                
                <!-- Nueva imagen -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cambiar imagen</label>
                    <input type="file" name="imagen_principal" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la imagen actual</p>
                    @error('imagen_principal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Opciones -->
                <div class="md:col-span-2 flex gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado', $producto->destacado) ? 'checked' : '' }} class="rounded mr-2">
                        <span class="text-sm">Producto destacado</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="disponible" value="1" {{ old('disponible', $producto->disponible) ? 'checked' : '' }} class="rounded mr-2">
                        <span class="text-sm">Disponible</span>
                    </label>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.productos.index') }}" 
                   class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#6a1c32] text-white rounded-lg hover:bg-[#993233]">
                    Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection



