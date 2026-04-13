@extends('layouts.public')

@section('title', $categoria->nombre)

@section('content')
<!-- Header -->
<div class="py-12" style="background-color: {{ $categoria->color }};">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('catalogo.index') }}" class="text-white hover:underline">← Volver al catálogo</a>
        </div>
        <h1 class="text-4xl font-bold text-white mb-2">{{ $categoria->nombre }}</h1>
        <p class="text-xl text-white opacity-90">{{ $categoria->descripcion }}</p>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white shadow-md sticky top-20 z-40">
    <div class="container mx-auto px-4 py-4">
        <form method="GET" class="flex gap-4">
            <input type="text" 
                   name="search" 
                   placeholder="Buscar en {{ $categoria->nombre }}..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent">
            
            <button type="submit" 
                    class="px-6 py-2 text-white rounded-lg font-medium transition"
                    style="background-color: {{ $categoria->color }};">
                Buscar
            </button>
            
            @if(request('search'))
                <a href="{{ route('catalogo.categoria', $categoria) }}" 
                   class="px-6 py-2 border rounded-lg font-medium text-gray-600 hover:bg-gray-50 transition">
                    Limpiar
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Otras categorías -->
<div class="bg-gray-50 py-6">
    <div class="container mx-auto px-4">
        <p class="text-sm text-gray-600 mb-3">Otras categorías:</p>
        <div class="flex flex-wrap gap-2">
            @foreach($categorias as $cat)
                @if($cat->id != $categoria->id)
                    <a href="{{ route('catalogo.categoria', $cat) }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition"
                       style="background-color: {{ $cat->color }}20; color: {{ $cat->color }};"
                       onmouseover="this.style.backgroundColor='{{ $cat->color }}40'"
                       onmouseout="this.style.backgroundColor='{{ $cat->color }}20'">
                        {{ $cat->nombre }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Grid de productos -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <p class="text-gray-600">{{ $productos->total() }} productos en {{ $categoria->nombre }}</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($productos as $producto)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <a href="{{ route('producto.show', $producto) }}">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $producto->imagen_principal_url }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @if($producto->destacado)
                            <span class="absolute top-2 right-2 px-3 py-1 text-xs font-bold text-white rounded-full" 
                                  style="background-color: #b17a45;">
                                Destacado
                            </span>
                        @endif
                    </div>
                </a>
                <div class="p-5">
                    <a href="{{ route('producto.show', $producto) }}">
                        <h3 class="text-lg font-semibold mb-2 hover:text-[#6a1c32] transition">
                            {{ $producto->nombre }}
                        </h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($producto->descripcion, 80) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">{{ $producto->temporada ?? 'Todo el año' }}</span>
                        <a href="{{ route('producto.show', $producto) }}" 
                           class="text-sm font-medium hover:underline" style="color: {{ $categoria->color }};">
                            Ver →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No hay productos en esta categoría.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $productos->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection


