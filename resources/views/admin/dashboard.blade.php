@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Productores</p>
                <p class="text-3xl font-bold text-[#3c3c3b]">{{ $totalProductores }}</p>
            </div>
            <div class="w-12 h-12 bg-[#6a1c32] bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-[#6a1c32] text-xl">👥</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pendientes de aprobación</p>
                <p class="text-3xl font-bold text-[#993233]">{{ $productoresPendientes }}</p>
            </div>
            <div class="w-12 h-12 bg-[#993233] bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-[#993233] text-xl">⏳</span>
            </div>
        </div>
        @if($productoresPendientes > 0)
            <a href="{{ route('admin.productores.index', ['status' => 'pendiente']) }}" 
               class="text-sm text-[#6a1c32] hover:underline mt-2 inline-block">
                Revisar pendientes →
            </a>
        @endif
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Productores Aprobados</p>
                <p class="text-3xl font-bold text-green-600">{{ $productoresAprobados }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-green-600 text-xl">✅</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Productos</p>
                <p class="text-3xl font-bold text-[#3c3c3b]">{{ $totalProductos }}</p>
            </div>
            <div class="w-12 h-12 bg-[#b17a45] bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-[#b17a45] text-xl">📦</span>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Últimos productores registrados -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-bold mb-4 text-[#3c3c3b]">Últimos productores registrados</h2>
        <div class="space-y-3">
            @forelse($ultimosProductores as $productor)
            <div class="flex items-center justify-between py-2 border-b">
                <div>
                    <p class="font-medium">{{ $productor->nombre_empresa }}</p>
                    <p class="text-sm text-gray-500">{{ $productor->municipio->nombre }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs px-2 py-1 rounded-full 
                        {{ $productor->estatus === 'aprobado' ? 'bg-green-100 text-green-700' : 
                           ($productor->estatus === 'pendiente' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($productor->estatus) }}
                    </span>
                    <a href="{{ route('admin.productores.show', $productor) }}" 
                       class="text-[#6a1c32] hover:underline text-sm">Ver</a>
                </div>
            </div>
            @empty
            <p class="text-gray-500">No hay productores registrados.</p>
            @endforelse
        </div>
        <a href="{{ route('admin.productores.index') }}" class="text-sm text-[#6a1c32] hover:underline mt-4 inline-block">
            Ver todos los productores →
        </a>
    </div>
    
    <!-- Productores más vistos -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-bold mb-4 text-[#3c3c3b]">Productores más vistos</h2>
        <div class="space-y-3">
            @forelse($productoresPopulares as $productor)
            <div class="flex items-center justify-between py-2 border-b">
                <div>
                    <p class="font-medium">{{ $productor->nombre_empresa }}</p>
                    <p class="text-sm text-gray-500">{{ $productor->vistas }} vistas</p>
                </div>
                <a href="{{ route('admin.productores.show', $productor) }}" 
                   class="text-[#6a1c32] hover:underline text-sm">Ver</a>
            </div>
            @empty
            <p class="text-gray-500">No hay datos de vistas.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Productos más vistos -->
<div class="mt-8 bg-white rounded-xl shadow-md p-6">
    <h2 class="text-lg font-bold mb-4 text-[#3c3c3b]">Productos más consultados</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($productosPopulares as $producto)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium">{{ $producto->nombre }}</p>
                <p class="text-sm text-gray-500">{{ $producto->categoria->nombre }}</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-bold text-[#6a1c32]">{{ $producto->vistas }}</p>
                <p class="text-xs text-gray-500">vistas</p>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No hay datos de productos.</p>
        @endforelse
    </div>
</div>
@endsection