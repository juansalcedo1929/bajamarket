@extends('layouts.public')

@section('title', 'Catálogo de Productos')

@section('content')
<!-- Header -->
<div class="py-12 bg-[#6a1c32]">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white mb-4">Catálogo de Productos</h1>
        <p class="text-xl text-white opacity-90">Explora todos los productos agroindustriales de Baja California</p>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white shadow-md sticky top-20 z-40">
    <div class="container mx-auto px-4 py-4">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" 
                   name="search" 
                   placeholder="Buscar producto..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent">
            
            <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
            
            <select name="temporada" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
                <option value="">Todas las temporadas</option>
                @foreach($temporadas as $temp)
                    <option value="{{ $temp }}" {{ request('temporada') == $temp ? 'selected' : '' }}>
                        {{ $temp }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" 
                    class="px-6 py-2 text-white rounded-lg font-medium transition bg-[#6a1c32] hover:bg-[#993233]">
                Filtrar
            </button>
            
            @if(request()->anyFilled(['search', 'categoria', 'temporada']))
                <a href="{{ route('catalogo.index') }}" 
                   class="px-6 py-2 border rounded-lg font-medium text-gray-600 hover:bg-gray-50 transition text-center">
                    Limpiar
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Categorías rápidas -->
<div class="bg-gray-50 py-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap gap-2">
            @foreach($categorias as $cat)
                @php
                    $bgColor = $cat->color . '20';
                    $textColor = $cat->color;
                    $hoverBg = $cat->color . '40';
                @endphp
                <a href="{{ route('catalogo.categoria', $cat) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition"
                   style="background-color: {{ $bgColor }}; color: {{ $textColor }};"
                   onmouseover="this.style.backgroundColor='{{ $hoverBg }}'"
                   onmouseout="this.style.backgroundColor='{{ $bgColor }}'">
                    {{ $cat->nombre }} ({{ $cat->productos_count }})
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Grid de productos -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <p class="text-gray-600">{{ $productos->total() }} productos encontrados</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($productos as $producto)
            @php
                $bgColor = $producto->categoria->color . '20';
                $textColor = $producto->categoria->color;
            @endphp
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <a href="{{ route('producto.show', $producto) }}">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $producto->imagen_principal_url }}" 
                             alt="{{ $producto->nombre }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @if($producto->destacado)
                            <span class="absolute top-2 right-2 px-3 py-1 text-xs font-bold text-white rounded-full bg-[#b17a45]">
                                Destacado
                            </span>
                        @endif
                    </div>
                </a>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs px-3 py-1 rounded-full"
                              style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            {{ $producto->categoria->nombre }}
                        </span>
                        @if($producto->temporada)
                            <span class="text-xs text-gray-500">{{ $producto->temporada }}</span>
                        @endif
                    </div>
                    <a href="{{ route('producto.show', $producto) }}">
                        <h3 class="text-xl font-semibold mb-2 hover:text-[#6a1c32] transition">
                            {{ $producto->nombre }}
                        </h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                    <div class="flex items-center justify-between">
                      <span class="text-sm text-gray-500">
    @php
        $count = $producto->productoresAprobados()->count();
    @endphp
    {{ $count }} {{ $count == 1 ? 'productor' : 'productores' }}
</span>
                        <a href="{{ route('producto.show', $producto) }}" 
                           class="text-sm font-medium hover:underline text-[#6a1c32]">
                            Ver productores →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No se encontraron productos.</p>
                <a href="{{ route('catalogo.index') }}" class="text-[#6a1c32] hover:underline mt-2 inline-block">
                    Ver todos los productos
                </a>
            </div>
            @endforelse
        </div>
        
        <!-- Paginación -->
        <div class="mt-8">
            {{ $productos->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection


