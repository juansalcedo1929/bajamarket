@extends('layouts.public')

@section('title', $producto->nombre)

@push('styles')
<style>
    .producer-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgb(0 0 0 / 0.1);
    }
    
    /* Scroll suave para muchos productores */
    .producers-grid {
        max-height: 600px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #b17a45 #e5e7eb;
    }
    
    .producers-grid::-webkit-scrollbar {
        width: 6px;
    }
    
    .producers-grid::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 10px;
    }
    
    .producers-grid::-webkit-scrollbar-thumb {
        background: #b17a45;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-100 py-2.5">
    <div class="container mx-auto px-4">
        <nav class="text-xs md:text-sm">
            <a href="{{ route('landing') }}" class="text-gray-600 hover:text-[#6a1c32]">Inicio</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('catalogo.index') }}" class="text-gray-600 hover:text-[#6a1c32]">Catálogo</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('catalogo.categoria', $producto->categoria) }}" class="text-gray-600 hover:text-[#6a1c32]">
                {{ $producto->categoria->nombre }}
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#6a1c32] font-medium">{{ $producto->nombre }}</span>
        </nav>
    </div>
</div>

<!-- Producto Info -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-2/5">
                    <img src="{{ $producto->imagen_principal_url }}" 
                         alt="{{ $producto->nombre }}" 
                         class="w-full h-full object-cover" style="min-height: 350px;"
                         >
                </div>
                
                <div class="md:w-3/5 p-6 md:p-8">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @php
                            $bgColor = $producto->categoria->color . '20';
                            $textColor = $producto->categoria->color;
                        @endphp
                        <span class="px-3 py-1 text-xs md:text-sm rounded-full"
                              style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            {{ $producto->categoria->nombre }}
                        </span>
                        @if($producto->destacado)
                            <span class="px-3 py-1 text-xs font-bold text-white rounded-full bg-[#b17a45]">
                                Destacado
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl md:text-3xl font-bold mb-3 text-[#3c3c3b]">{{ $producto->nombre }}</h1>
                    <p class="text-gray-700 mb-4 leading-relaxed">{{ $producto->descripcion }}</p>
                    
                    <div class="flex flex-wrap gap-4 mb-4 text-sm">
                        @if($producto->temporada)
                        <div>
                            <span class="text-gray-500">📅 Temporada:</span>
                            <span class="font-medium ml-1">{{ $producto->temporada }}</span>
                        </div>
                        @endif
                        @if($producto->unidad_medida)
                        <div>
                            <span class="text-gray-500">📦 Unidad:</span>
                            <span class="font-medium ml-1">{{ $producto->unidad_medida }}</span>
                        </div>
                        @endif
                    </div>
                    
                    @if($producto->beneficios && count($producto->beneficios) > 0)
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <h3 class="font-semibold text-sm mb-1 text-[#6a1c32]">Beneficios</h3>
                        <ul class="list-disc list-inside text-gray-700 text-sm space-y-0.5">
                            @foreach($producto->beneficios as $beneficio)
                                <li>{{ $beneficio }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="flex items-center gap-3 text-sm text-gray-500 border-t pt-4">
                        <span>👁️ {{ $producto->vistas }} vistas</span>
                        <span>•</span>
                        <span><strong class="text-[#6a1c32]">{{ $productores->count() }}</strong> productores ofertan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productores que ofertan -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        {{-- Header con filtros --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-5">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-[#3c3c3b]">
                    Productores de {{ $producto->nombre }}
                </h2>
                <p class="text-sm text-gray-500">{{ $productores->count() }} productores encontrados</p>
            </div>
            
            <form method="GET" class="mt-3 md:mt-0 flex gap-2 w-full md:w-auto">
                <select name="municipio" 
                        class="flex-1 md:flex-none px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                    <option value="">Todos los municipios</option>
                    @foreach($municipios as $municipio)
                        <option value="{{ $municipio->id }}" {{ request('municipio') == $municipio->id ? 'selected' : '' }}>
                            {{ $municipio->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" 
                        class="px-4 py-1.5 text-sm text-white rounded-lg bg-[#6a1c32] hover:bg-[#993233] transition">
                    Filtrar
                </button>
                @if(request('municipio'))
                    <a href="{{ route('producto.show', $producto) }}" 
                       class="px-3 py-1.5 text-sm border rounded-lg text-gray-600 hover:bg-gray-100">
                        ✕
                    </a>
                @endif
            </form>
        </div>
        
        {{-- GRID OPTIMIZADO PARA MUCHOS PRODUCTORES --}}
        <div class="producers-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 pr-1">
            @forelse($productores as $productor)
            <div class="bg-white rounded-lg shadow-sm p-3 border border-gray-100 producer-card transition-all">
                <div class="flex items-center gap-2.5">
                    {{-- LOGO --}}
           @if($productor->logo)
    <img src="{{ $productor->logo_url }}" alt="{{ $productor->nombre_empresa }}" class="w-10 h-10 rounded-full object-cover border border-white shadow-sm hover:opacity-80">
@else
    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold bg-gradient-to-br from-[#6a1c32] to-[#b17a45] shadow-sm hover:opacity-80">
        {{ substr($productor->nombre_empresa, 0, 1) }}
    </div>
@endif
                    </a>
                    
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('directorio.show', $productor) }}" class="hover:underline">
                            <h3 class="font-semibold text-sm text-[#3c3c3b] truncate">{{ $productor->nombre_empresa }}</h3>
                        </a>
                        
                        <div class="flex items-center gap-2 text-[10px] text-gray-500 mt-0.5">
                            <span class="flex items-center truncate">
                                <svg class="w-3 h-3 mr-0.5 text-[#b17a45] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                <span class="truncate">{{ $productor->municipio?->nombre ?? 'N/A' }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                
                @php
                    $pivot = $productor->productos->find($producto->id)->pivot ?? null;
                @endphp
                
                {{-- DETALLES MÍNIMOS --}}
                @if($pivot && ($pivot->presentacion || $pivot->organico))
                <div class="mt-2 text-[10px] text-gray-500 space-y-0.5 border-t pt-1.5">
                    @if($pivot->presentacion)
                        <p class="truncate">{{ $pivot->presentacion }}</p>
                    @endif
                    @if($pivot->organico)
                        <p class="text-green-600 text-[10px]">🌱 Orgánico</p>
                    @endif
                </div>
                @endif
                
                {{-- BOTONES DE CONTACTO - DISEÑO REDONDO --}}
                <div class="flex items-center gap-1.5 mt-2">
                    <a href="tel:{{ $productor->telefono_principal }}" 
                       class="flex-1 flex items-center justify-center gap-1 px-2 py-1.5 bg-[#6a1c32] text-white rounded-full text-[10px] font-medium hover:bg-[#993233] transition-all shadow-sm hover:shadow"
                       title="Llamar a {{ $productor->nombre_contacto }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>Llamar</span>
                    </a>
                    
                    @if($productor->whatsapp)
                        <a href="https://wa.me/{{ $productor->whatsapp }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-1 px-2 py-1.5 bg-green-500 text-white rounded-full text-[10px] font-medium hover:bg-green-600 transition-all shadow-sm hover:shadow"
                           title="WhatsApp">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.087-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.828z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                    @elseif($productor->telefono_principal)
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $productor->telefono_principal);
                            if (strlen($waNumber) === 10) $waNumber = '52' . $waNumber;
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-1 px-2 py-1.5 bg-green-500 text-white rounded-full text-[10px] font-medium hover:bg-green-600 transition-all shadow-sm hover:shadow"
                           title="WhatsApp">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.087-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.828z"/>
                            </svg>
                            <span>WhatsApp</span>
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">No hay productores en este municipio.</p>
                <a href="{{ route('producto.show', $producto) }}" class="text-[#6a1c32] hover:underline mt-2 inline-block text-sm">
                    Ver todos los municipios
                </a>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Productos relacionados -->
@if($relacionados->count() > 0)
<section class="py-10">
    <div class="container mx-auto px-4">
        <h2 class="text-xl font-bold mb-5 text-[#3c3c3b]">Productos relacionados</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($relacionados as $relacionado)
            <a href="{{ route('producto.show', $relacionado) }}" 
               class="bg-white rounded-lg shadow-sm p-3 hover:shadow-md transition group border border-gray-100">
                <img src="{{ $relacionado->imagen_principal_url }}" 
                     alt="{{ $relacionado->nombre }}" 
                     class="w-full h-24 object-cover rounded mb-2"
                     >
                <h4 class="font-medium text-sm group-hover:text-[#6a1c32] transition truncate">{{ $relacionado->nombre }}</h4>
                <p class="text-[10px] text-gray-400 truncate">{{ $relacionado->categoria?->nombre ?? '' }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection


