@extends('layouts.admin')

@section('title', 'Ver Productor')
@section('page-title', 'Detalles del Productor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Banner -->
        @if($productor->banner)
            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ asset('storage/'.$productor->banner) }}')"></div>
        @else
            <div class="h-48 bg-gradient-to-r from-[#6a1c32] to-[#b17a45]"></div>
        @endif
        
        <div class="p-8">
            <div class="flex items-start gap-6 -mt-16">
                {{-- LOGO CORREGIDO --}}
                @if($productor->logo)
                    <img src="{{ asset('storage/' . $productor->logo) }}" 
                         alt="Logo de {{ $productor->nombre_empresa }}" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white text-3xl font-bold border-4 border-white">
                        {{ substr($productor->nombre_empresa, 0, 1) }}
                    </div>
                @endif
                
                <div class="flex-1 pt-12">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl font-bold text-[#3c3c3b]">{{ $productor->nombre_empresa }}</h1>
                        <span class="px-3 py-1 text-xs rounded-full 
                            {{ $productor->estatus === 'aprobado' ? 'bg-green-100 text-green-700' : 
                               ($productor->estatus === 'pendiente' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($productor->estatus) }}
                        </span>
                    </div>
                    <p class="text-gray-600">{{ $productor->municipio->nombre }}, Baja California</p>
                </div>
                
                <div class="flex gap-3 pt-12">
                    @if($productor->estatus === 'pendiente')
                        <form action="{{ route('admin.productores.aprobar', $productor) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Aprobar
                            </button>
                        </form>
                        <button onclick="showRejectModal({{ $productor->id }})" 
                                class="px-4 py-2 bg-[#993233] text-white rounded-lg hover:bg-red-700">
                            Rechazar
                        </button>
                    @endif
                    <a href="{{ route('admin.productores.edit', $productor) }}" 
                       class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">
                        Editar
                    </a>
                </div>
            </div>
            
            <!-- Información -->
            <div class="grid md:grid-cols-2 gap-8 mt-8">
                <div>
                    <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Información de contacto</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Contacto</dt>
                            <dd class="font-medium">{{ $productor->nombre_contacto }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd>{{ $productor->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Teléfono principal</dt>
                            <dd>{{ $productor->telefono_principal }}</dd>
                        </div>
                        @if($productor->telefono_secundario)
                        <div>
                            <dt class="text-sm text-gray-500">Teléfono secundario</dt>
                            <dd>{{ $productor->telefono_secundario }}</dd>
                        </div>
                        @endif
                        @if($productor->whatsapp)
                        <div>
                            <dt class="text-sm text-gray-500">WhatsApp</dt>
                            <dd>{{ $productor->whatsapp }}</dd>
                        </div>
                        @endif
                        @if($productor->sitio_web)
                        <div>
                            <dt class="text-sm text-gray-500">Sitio web</dt>
                            <dd><a href="{{ $productor->sitio_web }}" target="_blank" class="text-[#6a1c32] hover:underline">{{ $productor->sitio_web }}</a></dd>
                        </div>
                        @endif
                        @if($productor->rfc)
                        <div>
                            <dt class="text-sm text-gray-500">RFC</dt>
                            <dd>{{ $productor->rfc }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
                
                <div>
                    <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Ubicación</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Dirección</dt>
                            <dd>{{ $productor->direccion }}</dd>
                        </div>
                        @if($productor->colonia)
                        <div>
                            <dt class="text-sm text-gray-500">Colonia</dt>
                            <dd>{{ $productor->colonia }}</dd>
                        </div>
                        @endif
                        @if($productor->codigo_postal)
                        <div>
                            <dt class="text-sm text-gray-500">Código Postal</dt>
                            <dd>{{ $productor->codigo_postal }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
            
            <!-- Redes Sociales -->
            @if($productor->facebook || $productor->instagram || $productor->twitter)
            <div class="mt-6">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Redes Sociales</h3>
                <div class="flex gap-4">
                    @if($productor->facebook)
                        <a href="{{ $productor->facebook }}" target="_blank" class="text-blue-600 hover:underline">Facebook</a>
                    @endif
                    @if($productor->instagram)
                        <a href="{{ $productor->instagram }}" target="_blank" class="text-pink-600 hover:underline">Instagram</a>
                    @endif
                    @if($productor->twitter)
                        <a href="{{ $productor->twitter }}" target="_blank" class="text-blue-400 hover:underline">Twitter</a>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Productos -->
            <div class="mt-8">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Productos que oferta</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($productor->productos as $producto)
                        <span class="px-3 py-2 bg-gray-100 rounded-lg text-sm">
                            {{ $producto->nombre }} ({{ $producto->categoria->nombre }})
                        </span>
                    @empty
                        <p class="text-gray-500">No hay productos registrados.</p>
                    @endforelse
                </div>
            </div>
            
            @if($productor->descripcion)
            <div class="mt-8">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Descripción</h3>
                <p class="text-gray-700">{{ $productor->descripcion }}</p>
            </div>
            @endif
            
            <!-- Certificaciones -->
            @if($productor->certificaciones)
            <div class="mt-8">
                <h3 class="font-bold text-lg mb-4 text-[#6a1c32]">Certificaciones</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($productor->certificaciones as $cert)
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">{{ $cert }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Estadísticas -->
            <div class="mt-8 pt-8 border-t">
                <div class="flex gap-8">
                    <div>
                        <p class="text-sm text-gray-500">Vistas</p>
                        <p class="text-2xl font-bold text-[#6a1c32]">{{ $productor->vistas }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contactos recibidos</p>
                        <p class="text-2xl font-bold text-[#b17a45]">{{ $productor->contactos }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fecha de registro</p>
                        <p class="text-lg">{{ $productor->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
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


