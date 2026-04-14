@extends('layouts.public')

@section('title', 'Directorio de Productores')

@section('content')
<!-- Header -->
<div class="py-12 bg-[#6a1c32]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-4">Directorio de Productores</h1>
        <p class="text-xl text-white opacity-90">Conoce a los productores agroindustriales de Baja California</p>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white shadow-md sticky top-20 z-40">
    <div class="container mx-auto px-4 py-4">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" 
                   name="search" 
                   placeholder="Buscar productor..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent">
            
            <select name="municipio" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                <option value="">Todos los municipios</option>
                @foreach($municipios as $mun)
                    <option value="{{ $mun->id }}" {{ request('municipio') == $mun->id ? 'selected' : '' }}>
                        {{ $mun->nombre }}
                    </option>
                @endforeach
            </select>
            
            <select name="producto" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                <option value="">Todos los productos</option>
                @foreach($productos as $prod)
                    <option value="{{ $prod->id }}" {{ request('producto') == $prod->id ? 'selected' : '' }}>
                        {{ $prod->nombre }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" 
                    class="px-6 py-2 text-white rounded-lg font-medium transition bg-[#6a1c32] hover:bg-[#993233]">
                Filtrar
            </button>
            
            @if(request()->anyFilled(['search', 'municipio', 'producto']))
                <a href="{{ route('directorio.index') }}" 
                   class="px-6 py-2 border rounded-lg font-medium text-gray-600 hover:bg-gray-50 transition text-center">
                    Limpiar
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Grid de productores -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <p class="text-gray-600">{{ $productores->total() }} productores encontrados</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($productores as $productor)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                @if($productor->banner)
                    <img src="{{ asset('storage/'.$productor->banner) }}" 
                         alt="{{ $productor->nombre_empresa }}" 
                         class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-32 bg-gradient-to-r from-[#6a1c32] to-[#b17a45]"></div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        {{-- LOGO CORREGIDO --}}
                 @if($productor->logo)
    <img src="{{ $productor->logo_url }}" alt="Logo" class="w-10 h-10 rounded-full object-cover mr-3">
@else
    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white font-bold mr-3">
        {{ substr($productor->nombre_empresa, 0, 1) }}
    </div>
@endif
                        
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-bold text-lg text-[#3c3c3b]">{{ $productor->nombre_empresa }}</h3>
                                @if($productor->destacado)
                                    <span class="text-xs px-2 py-1 bg-[#b17a45] text-white rounded-full">Destacado</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mb-2">{{ $productor->municipio->nombre }}</p>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Illuminate\Support\Str::limit($productor->descripcion, 80) }}</p>
                            
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($productor->productos->take(3) as $producto)
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
                                        {{ $producto->nombre }}
                                    </span>
                                @endforeach
                                @if($productor->productos->count() > 3)
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
                                        +{{ $productor->productos->count() - 3 }}
                                    </span>
                                @endif
                            </div>
                            
                            <a href="{{ route('directorio.show', $productor) }}" 
                               class="inline-block text-sm font-medium text-[#6a1c32] hover:underline">
                                Ver perfil completo →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No se encontraron productores.</p>
                <a href="{{ route('directorio.index') }}" class="text-[#6a1c32] hover:underline mt-2 inline-block">
                    Ver todos los productores
                </a>
            </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $productores->appends(request()->query())->links() }}
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4 text-[#3c3c3b]">¿Eres productor?</h2>
        <p class="text-lg text-gray-600 mb-6">Regístrate gratis y aparece en nuestro directorio</p>
        <a href="{{ route('registro.create') }}" 
           class="inline-block px-8 py-3 text-white rounded-lg font-semibold bg-[#6a1c32] hover:bg-[#993233] transition">
            Registrar mi negocio
        </a>
    </div>
</section>
@endsection



