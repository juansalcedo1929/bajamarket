@extends('layouts.admin')

@section('title', 'Editar Productor')
@section('page-title', 'Editar Productor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.productores.update', $productor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Nombre de empresa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la empresa *</label>
                    <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $productor->nombre_empresa) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('nombre_empresa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nombre de contacto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de contacto *</label>
                    <input type="text" name="nombre_contacto" value="{{ old('nombre_contacto', $productor->nombre_contacto) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('nombre_contacto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $productor->email) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Teléfono principal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono principal *</label>
                    <input type="text" name="telefono_principal" value="{{ old('telefono_principal', $productor->telefono_principal) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('telefono_principal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Teléfono secundario -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono secundario</label>
                    <input type="text" name="telefono_secundario" value="{{ old('telefono_secundario', $productor->telefono_secundario) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- WhatsApp -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $productor->whatsapp) }}" placeholder="521234567890"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Sitio web -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sitio web</label>
                    <input type="url" name="sitio_web" value="{{ old('sitio_web', $productor->sitio_web) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $productor->direccion) }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    @error('direccion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Colonia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Colonia</label>
                    <input type="text" name="colonia" value="{{ old('colonia', $productor->colonia) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Código Postal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                    <input type="text" name="codigo_postal" value="{{ old('codigo_postal', $productor->codigo_postal) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                </div>
                
                <!-- Municipio -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Municipio *</label>
                    <select name="municipio_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                        <option value="">Selecciona un municipio</option>
                        @foreach($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ old('municipio_id', $productor->municipio_id) == $municipio->id ? 'selected' : '' }}>
                                {{ $municipio->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipio_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- LOGO ACTUAL --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo actual</label>
                    <div class="flex items-center gap-4">
                        @if($productor->logo)
                            <img src="{{ asset('storage/' . $productor->logo) }}" 
                                 alt="Logo actual" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($productor->nombre_empresa, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-sm text-gray-500">Logo actual del productor</span>
                    </div>
                </div>
                
                {{-- CAMBIAR LOGO --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cambiar logo</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                        <input type="file" 
                               name="logo" 
                               id="logoInput"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#6a1c32] file:text-white hover:file:bg-[#993233]">
                        <p class="text-xs text-gray-400 mt-2">Formatos: JPG, PNG, GIF, WEBP. Máximo 2MB.</p>
                        <p class="text-xs text-gray-400">Dejar vacío para mantener el logo actual.</p>
                    </div>
                    @error('logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- PREVISUALIZACIÓN DEL NUEVO LOGO --}}
                <div class="md:col-span-2" id="previewContainer" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vista previa del nuevo logo</label>
                    <img id="logoPreview" src="#" alt="Vista previa" class="w-20 h-20 rounded-full object-cover border-2 border-green-500">
                </div>
                
                <!-- Productos -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Productos que oferta *</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-60 overflow-y-auto p-3 border rounded-lg">
                        @foreach($productos as $producto)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="productos[]" value="{{ $producto->id }}" 
                                       {{ in_array($producto->id, old('productos', $productor->productos->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-[#6a1c32] focus:ring-[#6a1c32]">
                                <span class="text-sm">{{ $producto->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('productos')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">{{ old('descripcion', $productor->descripcion) }}</textarea>
                </div>
                
                <!-- Facebook -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                    <input type="url" name="facebook" value="{{ old('facebook', $productor->facebook) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                    <input type="url" name="instagram" value="{{ old('instagram', $productor->instagram) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                
                <!-- Destacado -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado', $productor->destacado) ? 'checked' : '' }} 
                               class="rounded border-gray-300 text-[#6a1c32] focus:ring-[#6a1c32]">
                        <span class="ml-2 text-sm text-gray-700">Productor destacado</span>
                    </label>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                <a href="{{ route('admin.productores.show', $productor) }}" 
                   class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#6a1c32] text-white rounded-lg hover:bg-[#993233] transition">
                    Actualizar Productor
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Previsualización del logo
    document.getElementById('logoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('logoPreview');
        const container = document.getElementById('previewContainer');
        
        if (file) {
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen no debe pesar más de 2MB');
                this.value = '';
                container.style.display = 'none';
                return;
            }
            
            // Validar tipo
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Formato no válido. Usa JPG, PNG, GIF o WEBP');
                this.value = '';
                container.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    });
</script>
@endpush
@endsection