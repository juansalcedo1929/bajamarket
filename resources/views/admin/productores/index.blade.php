@extends('layouts.admin')

@section('title', 'Gestión de Productores')
@section('page-title', 'Productores')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Tabs -->
    <div class="border-b">
        <nav class="flex">
            <a href="{{ route('admin.productores.index', ['status' => 'pendiente']) }}" 
               class="px-6 py-3 text-sm font-medium {{ $status === 'pendiente' ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : 'text-gray-500 hover:text-gray-700' }}">
                Pendientes ({{ $pendientes }})
            </a>
            <a href="{{ route('admin.productores.index', ['status' => 'aprobado']) }}" 
               class="px-6 py-3 text-sm font-medium {{ $status === 'aprobado' ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : 'text-gray-500 hover:text-gray-700' }}">
                Aprobados ({{ $aprobados }})
            </a>
            <a href="{{ route('admin.productores.index', ['status' => 'rechazado']) }}" 
               class="px-6 py-3 text-sm font-medium {{ $status === 'rechazado' ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : 'text-gray-500 hover:text-gray-700' }}">
                Rechazados ({{ $rechazados }})
            </a>
        </nav>
    </div>
    
    <!-- Filtro de búsqueda -->
    <div class="p-4 border-b">
        <form method="GET" class="flex gap-4">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" 
                   name="search" 
                   placeholder="Buscar por nombre, contacto o email..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#6a1c32]">
            <button type="submit" class="px-4 py-2 bg-[#6a1c32] text-white rounded-lg hover:bg-[#993233]">
                Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('admin.productores.index', ['status' => $status]) }}" 
                   class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Limpiar
                </a>
            @endif
        </form>
    </div>
    
    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empresa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contacto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Municipio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Productos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($productores as $productor)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            {{-- LOGO CORREGIDO --}}
                            @if($productor->logo)
                                <img src="{{ $productor->logo_url }}" 
                                     alt="Logo" 
                                     class="w-10 h-10 rounded-full object-cover mr-3">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white font-bold mr-3">
                                    {{ substr($productor->nombre_empresa, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $productor->nombre_empresa }}</p>
                                <p class="text-xs text-gray-500">{{ $productor->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p>{{ $productor->nombre_contacto }}</p>
                        <p class="text-sm text-gray-500">{{ $productor->telefono_principal }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $productor->municipio->nombre }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($productor->productos->take(3) as $producto)
                                <span class="text-xs px-2 py-1 bg-gray-100 rounded-full">{{ $producto->nombre }}</span>
                            @endforeach
                            @if($productor->productos->count() > 3)
                                <span class="text-xs px-2 py-1 bg-gray-100 rounded-full">+{{ $productor->productos->count() - 3 }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $productor->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.productores.show', $productor) }}" 
                               class="text-blue-600 hover:text-blue-800" title="Ver">
                                👁️
                            </a>
                            
                            @if($productor->estatus === 'pendiente')
                                <form action="{{ route('admin.productores.aprobar', $productor) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800" title="Aprobar">
                                        ✅
                                    </button>
                                </form>
                                <button onclick="showRejectModal({{ $productor->id }})" 
                                        class="text-red-600 hover:text-red-800" title="Rechazar">
                                    ❌
                                </button>
                            @endif
                            
                            <a href="{{ route('admin.productores.edit', $productor) }}" 
                               class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                ✏️
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No hay productores {{ $status }}s
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="p-4 border-t">
        {{ $productores->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal de rechazo -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-xl font-bold mb-4 text-[#3c3c3b]">Rechazar productor</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="motivo_rechazo" rows="3" required 
                      class="w-full px-3 py-2 border rounded-lg mb-4" 
                      placeholder="Motivo del rechazo..."></textarea>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" 
                        class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-[#993233] text-white rounded-lg hover:bg-red-700">
                    Rechazar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(id) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/productores/${id}/rechazar`;
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
</script>
@endsection



