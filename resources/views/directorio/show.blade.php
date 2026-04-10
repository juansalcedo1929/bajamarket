@extends('layouts.public')

@section('title', $productor->nombre_empresa)

@section('content')
<div class="bg-gray-100 py-3">
    <div class="container mx-auto px-4">
        <nav class="text-sm">
            <a href="{{ route('landing') }}" class="text-gray-600 hover:text-[#6a1c32]">Inicio</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('directorio.index') }}" class="text-gray-600 hover:text-[#6a1c32]">Directorio</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#6a1c32] font-medium">{{ $productor->nombre_empresa }}</span>
        </nav>
    </div>
</div>

<!-- Banner -->
@if($productor->banner)
    <div class="w-full h-48 md:h-64 bg-cover bg-center" style="background-image: url('{{ asset('storage/'.$productor->banner) }}')"></div>
@else
    <div class="w-full h-48 md:h-64 bg-gradient-to-r from-[#6a1c32] to-[#b17a45]"></div>
@endif

<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg -mt-16 relative z-10 p-8">
            <div class="flex flex-col md:flex-row items-start gap-6">
                <!-- Logo - CORREGIDO -->
                @if($productor->logo)
                    <img src="{{ asset('storage/' . $productor->logo) }}" 
                         alt="{{ $productor->nombre_empresa }}" 
                         class="w-24 h-24 rounded-full object-cover flex-shrink-0 border-4 border-white shadow-lg">
                @else
                    <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-bold bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex-shrink-0 border-4 border-white shadow-lg">
                        {{ substr($productor->nombre_empresa, 0, 1) }}
                    </div>
                @endif
                
                <!-- Info principal -->
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold text-[#3c3c3b]">{{ $productor->nombre_empresa }}</h1>
                        @if($productor->destacado)
                            <span class="px-3 py-1 text-xs font-bold text-white rounded-full bg-[#b17a45]">Destacado</span>
                        @endif
                        @if($productor->verificado)
                            <span class="px-3 py-1 text-xs font-bold text-white rounded-full bg-green-600">✓ Verificado</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-600 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-[#b17a45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $productor->municipio->nombre }}, Baja California
                    </p>
                    
                    @if($productor->descripcion)
                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-700">{{ $productor->descripcion }}</p>
                        </div>
                    @endif
                    <!-- Botones de contacto -->
<div class="flex flex-wrap gap-3">
    {{-- BOTÓN LLAMAR - DIRECTO AL TELÉFONO --}}
    <a href="tel:{{ $productor->telefono_principal }}" 
       class="px-6 py-2 text-white rounded-lg font-medium bg-[#6a1c32] hover:bg-[#993233] transition shadow-md hover:shadow-lg">
        📞 Llamar ahora
    </a>
    
    @if($productor->whatsapp)
        <a href="https://wa.me/{{ $productor->whatsapp }}" target="_blank"
           class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition shadow-md hover:shadow-lg">
            💬 WhatsApp
        </a>
    @endif
    
    @if($productor->sitio_web)
        <a href="{{ $productor->sitio_web }}" target="_blank"
           class="px-6 py-2 border-2 border-[#6a1c32] text-[#6a1c32] rounded-lg font-medium hover:bg-[#6a1c32] hover:text-white transition">
            🌐 Sitio Web
        </a>
    @endif
</div>
                  
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productos que oferta -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6 text-[#3c3c3b]">Productos que oferta</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($productor->productos as $producto)
                <a href="{{ route('producto.show', $producto) }}" 
                   class="bg-white rounded-lg shadow p-4 hover:shadow-md transition border border-gray-100">
                    <div class="text-center">
                        <h4 class="font-medium text-[#6a1c32]">{{ $producto->nombre }}</h4>
                        <p class="text-xs text-gray-500">{{ $producto->categoria->nombre }}</p>
                        @if($producto->pivot->presentacion)
                            <p class="text-xs text-gray-400 mt-1">{{ $producto->pivot->presentacion }}</p>
                        @endif
                        @if($producto->pivot->organico)
                            <p class="text-xs text-green-600 mt-1">🌱 Orgánico</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="col-span-full text-center text-gray-500 py-8">No hay productos registrados.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Información de contacto -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32] flex items-center">
                    <span class="mr-2">📋</span> Información de Contacto
                </h3>
                <div class="space-y-3">
                    <p><span class="font-medium text-gray-700">Contacto:</span> {{ $productor->nombre_contacto }}</p>
                    <p><span class="font-medium text-gray-700">Email:</span> 
                        <a href="mailto:{{ $productor->email }}" class="text-[#6a1c32] hover:underline">{{ $productor->email }}</a>
                    </p>
                    <p><span class="font-medium text-gray-700">Teléfono:</span> 
                        <a href="tel:{{ $productor->telefono_principal }}" class="text-[#6a1c32] hover:underline">{{ $productor->telefono_principal }}</a>
                    </p>
                    @if($productor->telefono_secundario)
                        <p><span class="font-medium text-gray-700">Teléfono secundario:</span> {{ $productor->telefono_secundario }}</p>
                    @endif
                    @if($productor->rfc)
                        <p><span class="font-medium text-gray-700">RFC:</span> {{ $productor->rfc }}</p>
                    @endif
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32] flex items-center">
                    <span class="mr-2">📍</span> Ubicación
                </h3>
                <p class="mb-2 font-medium">{{ $productor->direccion }}</p>
                @if($productor->colonia)
                    <p class="text-gray-600">{{ $productor->colonia }}</p>
                @endif
                <p class="text-gray-600">{{ $productor->municipio->nombre }}, Baja California</p>
                @if($productor->codigo_postal)
                    <p class="text-gray-600">C.P. {{ $productor->codigo_postal }}</p>
                @endif
            </div>
        </div>
        
        <!-- Redes sociales -->
        @if($productor->facebook || $productor->instagram || $productor->twitter)
        <div class="mt-8 flex justify-center space-x-6">
            @if($productor->facebook)
                <a href="{{ $productor->facebook }}" target="_blank" 
                   class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl hover:bg-blue-700 transition">
                    f
                </a>
            @endif
            @if($productor->instagram)
                <a href="{{ $productor->instagram }}" target="_blank" 
                   class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 text-white rounded-full flex items-center justify-center text-xl hover:opacity-90 transition">
                    📷
                </a>
            @endif
            @if($productor->twitter)
                <a href="{{ $productor->twitter }}" target="_blank" 
                   class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center text-xl hover:bg-blue-500 transition">
                    🐦
                </a>
            @endif
        </div>
        @endif
    </div>
</section>




@endsection
