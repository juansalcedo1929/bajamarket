@extends('layouts.admin')

@section('title', 'Editar Categoría')
@section('page-title', 'Editar Categoría')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color *</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="{{ old('color', $categoria->color) }}" required 
                               class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                        <input type="text" id="colorText" value="{{ old('color', $categoria->color) }}" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                    @error('color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <!-- Orden -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                        <input type="number" name="orden" value="{{ old('orden', $categoria->orden) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    </div>
                    
                    <!-- Icono actual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icono actual</label>
                        @if($categoria->icono)
                            <img src="{{ asset('storage/'.$categoria->icono) }}" class="w-10 h-10 object-cover rounded">
                        @else
                            <p class="text-sm text-gray-500">No hay icono</p>
                        @endif
                    </div>
                </div>
                
                <!-- Nuevo icono -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cambiar icono</label>
                    <input type="file" name="icono" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <!-- Imagen actual -->
                @if($categoria->imagen)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen actual</label>
                    <img src="{{ asset('storage/'.$categoria->imagen) }}" class="w-full h-24 object-cover rounded-lg">
                </div>
                @endif
                
                <!-- Nueva imagen -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cambiar imagen de fondo</label>
                    <input type="file" name="imagen" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <!-- Opciones -->
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado', $categoria->destacado) ? 'checked' : '' }} class="rounded mr-2">
                        <span class="text-sm">Categoría destacada</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $categoria->activo) ? 'checked' : '' }} class="rounded mr-2">
                        <span class="text-sm">Activa</span>
                    </label>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.categorias.index') }}" 
                   class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#6a1c32] text-white rounded-lg hover:bg-[#993233]">
                    Actualizar Categoría
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('input[name="color"]').addEventListener('input', function() {
        document.getElementById('colorText').value = this.value;
    });
</script>
@endsection