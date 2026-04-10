@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
<!-- Hero Section con Banner img1.jpg -->
<section class="relative h-[500px] md:h-[600px] bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('images/img1.jpg') }}'), linear-gradient(135deg, #6a1c32 0%, #993233 100%);">
    <!-- Overlay oscuro para mejor legibilidad del texto -->
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    
    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
        <div class="max-w-3xl text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in drop-shadow-lg">
                Directorio Agroindustrial de Baja California
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-200 drop-shadow">
                Conectamos productores locales con compradores de todo México
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('catalogo.index') }}" 
                   class="px-8 py-4 bg-white text-[#6a1c32] rounded-lg font-semibold text-center hover:bg-gray-100 transition transform hover:-translate-y-1 shadow-lg">
                    Explorar Productos
                </a>
                <a href="{{ route('registro.create') }}" 
                   class="px-8 py-4 border-2 border-white text-white rounded-lg font-semibold text-center hover:bg-white hover:text-[#6a1c32] transition transform hover:-translate-y-1">
                    Registrar Productor
                </a>
            </div>
        </div>
    </div>
    
    <!-- Flecha hacia abajo -->
    <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 z-10 animate-bounce hidden md:block">
        <a href="#estadisticas" class="text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>

<!-- Estadísticas -->
<section id="estadisticas" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-5xl font-bold mb-2 text-[#6a1c32]">{{ $totalProductores }}</div>
                <p class="text-gray-600 text-lg">Productores Registrados</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2 text-[#b17a45]">{{ $totalProductos }}</div>
                <p class="text-gray-600 text-lg">Productos Disponibles</p>
            </div>
            <div class="text-center">
                <div class="text-5xl font-bold mb-2 text-[#993233]">{{ $totalMunicipios }}</div>
                <p class="text-gray-600 text-lg">Municipios</p>
            </div>
        </div>
    </div>
</section>

<!-- Categorías Destacadas -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-[#3c3c3b]">Categorías de Productos</h2>
        <p class="text-center text-gray-600 mb-12 text-lg max-w-2xl mx-auto">Explora nuestra amplia variedad de productos agroindustriales de la región</p>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categorias as $categoria)
            <a href="{{ route('catalogo.categoria', $categoria) }}" 
               class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-center group">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center"
                     style="background-color: {{ $categoria->color }}20;">
                    <span class="text-3xl" style="color: {{ $categoria->color }};">
                        @php
                            $iconos = [
                                'Frutas' => '🍎',
                                'Verduras' => '🥕',
                                'Lácteos' => '🥛',
                                'Quesos' => '🧀',
                                'Miel' => '🍯',
                                'Cárnicos' => '🥩',
                                'Vinos' => '🍷',
                                'Aceites' => '🫒',
                                'Granos' => '🌾',
                                'Hierbas' => '🌿'
                            ];
                        @endphp
                        {{ $iconos[$categoria->nombre] ?? '📦' }}
                    </span>
                </div>
                <h3 class="font-semibold text-lg mb-2 group-hover:text-[#6a1c32] transition">
                    {{ $categoria->nombre }}
                </h3>
                <p class="text-sm text-gray-500">{{ $categoria->productos_count }} productos</p>
            </a>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('catalogo.index') }}" 
               class="inline-block px-6 py-3 border-2 border-[#6a1c32] text-[#6a1c32] rounded-lg font-semibold hover:bg-[#6a1c32] hover:text-white transition">
                Ver todas las categorías →
            </a>
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-[#3c3c3b]">Productos Destacados</h2>
        <p class="text-center text-gray-600 mb-12 text-lg max-w-2xl mx-auto">Los productos más buscados de la temporada</p>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($productosDestacados as $producto)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition border border-gray-100">
                <div class="relative h-48 overflow-hidden bg-gray-200">
                    <img src="{{ $producto->imagen_principal_url }}" 
                         alt="{{ $producto->nombre }}" 
                         class="w-full h-full object-cover"
                         >
                    @if($producto->destacado)
                        <span class="absolute top-2 right-2 px-3 py-1 text-xs font-bold text-white rounded-full bg-[#b17a45]">
                            Destacado
                        </span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-3 py-1 rounded-full"
                              style="background-color: {{ $producto->categoria->color }}20; color: {{ $producto->categoria->color }};">
                            {{ $producto->categoria->nombre }}
                        </span>
                        @if($producto->temporada)
                        <span class="text-xs text-gray-500">{{ $producto->temporada }}</span>
                        @endif
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-[#3c3c3b]">{{ $producto->nombre }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2 text-sm">{{ Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                    <div class="flex items-center justify-between">
                      <span class="text-sm text-gray-500">
    @php
        $count = $producto->productoresAprobados()->count();
    @endphp
    {{ $count }} {{ $count == 1 ? 'productor' : 'productores' }}
</span>
                        <a href="{{ route('producto.show', $producto) }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#6a1c32] text-white rounded-lg text-sm font-medium hover:bg-[#993233] transition">
                            Ver productores →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Productores Destacados -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-[#3c3c3b]">Productores Destacados</h2>
        <p class="text-center text-gray-600 mb-12 text-lg max-w-2xl mx-auto">Conoce a nuestros productores más destacados de Baja California</p>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($productoresDestacados as $productor)
            <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition border border-gray-100">
                {{-- LOGO CORREGIDO - AQUÍ ESTABA EL PROBLEMA --}}
                @if($productor->logo)
                    <img src="{{ asset('storage/' . $productor->logo) }}" 
                         alt="{{ $productor->nombre_empresa }}" 
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center text-white text-2xl font-bold bg-gradient-to-br from-[#6a1c32] to-[#b17a45] shadow-lg">
                        {{ substr($productor->nombre_empresa, 0, 1) }}
                    </div>
                @endif
                
                <h4 class="font-semibold text-lg mb-1 text-[#3c3c3b]">{{ $productor->nombre_empresa }}</h4>
                <p class="text-sm text-gray-500 mb-2 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1 text-[#b17a45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $productor->municipio->nombre }}
                </p>
                <p class="text-xs text-gray-400 mb-4">
                    @php
                        $totalProductos = $productor->productos()->count();
                    @endphp
                    {{ $totalProductos }} {{ $totalProductos == 1 ? 'producto' : 'productos' }} ofertados
                </p>
                <a href="{{ route('directorio.show', $productor) }}" 
                   class="inline-block px-4 py-2 border border-[#6a1c32] text-[#6a1c32] rounded-lg text-sm font-medium hover:bg-[#6a1c32] hover:text-white transition">
                    Ver perfil →
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('directorio.index') }}" 
               class="inline-block px-6 py-3 bg-[#b17a45] text-white rounded-lg font-semibold hover:bg-[#8a5e35] transition">
                Ver todos los productores →
            </a>
        </div>
    </div>
</section>
<!-- CTA Final -->
<section class="py-20 text-white bg-gradient-to-r from-[#6a1c32] to-[#993233]">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-5xl font-bold mb-4">¿Eres productor de Baja California?</h2>
        <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">Regístrate gratis y conecta con compradores de todo México. ¡Aumenta tus ventas hoy mismo!</p>
        <a href="{{ route('registro.create') }}" 
           class="inline-block px-8 py-4 bg-white text-[#6a1c32] rounded-lg font-semibold text-lg hover:bg-gray-100 transition transform hover:-translate-y-1 shadow-lg">
            Registrar mi negocio ahora →
        </a>
        <p class="mt-6 text-sm opacity-75">Únete a {{ $totalProductores }}+ productores que ya confían en nosotros</p>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .drop-shadow-lg {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush
