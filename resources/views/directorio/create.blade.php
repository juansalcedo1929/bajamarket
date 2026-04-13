@extends('layouts.public')

@section('title', 'Registrar Productor')

@section('content')
<div class="py-12 bg-[#6a1c32]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-4">Registra tu negocio</h1>
        <p class="text-xl text-white opacity-90">Únete al directorio agroindustrial de Baja California</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="{{ route('registro.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Información básica -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Información del negocio</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la empresa *</label>
                            <input type="text" name="nombre_empresa" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de contacto *</label>
                            <input type="text" name="nombre_contacto" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>
                
                <!-- Contacto -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Información de contacto</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono principal *</label>
                            <input type="text" name="telefono_principal" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono secundario</label>
                            <input type="text" name="telefono_secundario" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" name="whatsapp" placeholder="521234567890" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sitio web</label>
                            <input type="url" name="sitio_web" placeholder="https://..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>
                
                <!-- Ubicación -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Ubicación</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección *</label>
                            <input type="text" name="direccion" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Colonia</label>
                            <input type="text" name="colonia" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                            <input type="text" name="codigo_postal" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
              <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1">Municipio *</label>
    <select name="municipio_id" required 
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent">
        <option value="">Selecciona un municipio</option>
        @foreach($municipios as $municipio)
            <option value="{{ $municipio->id }}" {{ old('municipio_id') == $municipio->id ? 'selected' : '' }}>
                {{ $municipio->nombre }}
            </option>
        @endforeach
    </select>
    @error('municipio_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
                    </div>
                </div>
                
                <!-- Productos -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Productos que ofertas *</h2>
                    <p class="text-sm text-gray-600 mb-3">Selecciona al menos un producto</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-60 overflow-y-auto p-2 border rounded-lg">
                        @foreach($productos as $producto)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="productos[]" value="{{ $producto->id }}" class="rounded">
                                <span class="text-sm">{{ $producto->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Descripción -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Descripción del negocio</h2>
                    <textarea name="descripcion" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>
                
                <!-- Redes sociales -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Redes sociales</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                            <input type="url" name="facebook" placeholder="https://facebook.com/..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                            <input type="url" name="instagram" placeholder="https://instagram.com/..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>
                
        <!-- Sección del Logo -->
<div class="mb-8">
    <h2 class="text-xl font-bold mb-4 text-[#6a1c32]">Logo de tu empresa (opcional)</h2>
    
    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
        <div class="text-center">
            <div class="mb-4" id="logoPreviewContainer">
                <img id="logoPreview" src="#" alt="Vista previa" class="hidden mx-auto max-h-32 rounded-lg">
                <div id="logoPlaceholder" class="text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm">Haz clic para seleccionar una imagen</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF o WEBP (Máx. 2MB)</p>
                </div>
            </div>
            
            <input type="file" 
                   name="logo" 
                   id="logoInput" 
                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                   class="hidden">
            
            <button type="button" 
                    onclick="document.getElementById('logoInput').click()"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Seleccionar imagen
            </button>
            
            <button type="button" 
                    onclick="clearLogo()"
                    id="clearLogoBtn"
                    class="px-4 py-2 text-red-600 hover:text-red-800 transition hidden">
                Eliminar
            </button>
        </div>
    </div>
    
    @error('logo')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
                <div class="flex justify-end gap-4">
                    <a href="{{ route('landing') }}" class="px-6 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 text-white rounded-lg font-medium bg-[#6a1c32] hover:bg-[#993233]">
                        Enviar registro
                    </button>
                </div>
                
                <p class="text-sm text-gray-500 mt-4 text-center">
                    Tu registro será revisado por un administrador antes de aparecer en el directorio.
                </p>
            </form>
        </div>
    </div>
    @push('scripts')
<script>
    const logoInput = document.getElementById('logoInput');
    const logoPreview = document.getElementById('logoPreview');
    const logoPlaceholder = document.getElementById('logoPlaceholder');
    const clearLogoBtn = document.getElementById('clearLogoBtn');
    
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('La imagen no debe pesar más de 2MB');
                logoInput.value = '';
                return;
            }
            
            // Validar tipo
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Formato no válido. Usa JPG, PNG, GIF o WEBP');
                logoInput.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('hidden');
                logoPlaceholder.classList.add('hidden');
                clearLogoBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
            
            // Mostrar nombre del archivo
            console.log('Archivo seleccionado:', file.name, 'Tipo:', file.type, 'Tamaño:', file.size);
        }
    });
    
    function clearLogo() {
        logoInput.value = '';
        logoPreview.classList.add('hidden');
        logoPlaceholder.classList.remove('hidden');
        clearLogoBtn.classList.add('hidden');
    }
</script>
@endpush
</section>
@endsection


