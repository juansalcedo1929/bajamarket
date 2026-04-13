<aside class="w-64 bg-[#3c3c3b] text-white min-h-screen">
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-[#b17a45]">
                <span class="text-white font-bold text-xl">B</span>
            </div>
            <div>
                <h2 class="font-bold">Baja Market</h2>
                <p class="text-xs text-gray-400">Panel Admin</p>
            </div>
        </div>
        
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#6a1c32] text-white' : 'text-gray-300 hover:bg-[#6a1c32] hover:text-white' }}">
                <span>📊</span>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.productores.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.productores.*') ? 'bg-[#6a1c32] text-white' : 'text-gray-300 hover:bg-[#6a1c32] hover:text-white' }}">
                <span>👥</span>
                <span>Productores</span>
                @php
                    $pendientes = \App\Models\Productor::pendientes()->count();
                @endphp
                @if($pendientes > 0)
                    <span class="ml-auto bg-[#993233] text-white text-xs px-2 py-1 rounded-full">{{ $pendientes }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.productos.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.productos.*') ? 'bg-[#6a1c32] text-white' : 'text-gray-300 hover:bg-[#6a1c32] hover:text-white' }}">
                <span>📦</span>
                <span>Productos</span>
            </a>
            
            <a href="{{ route('admin.categorias.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.categorias.*') ? 'bg-[#6a1c32] text-white' : 'text-gray-300 hover:bg-[#6a1c32] hover:text-white' }}">
                <span>🏷️</span>
                <span>Categorías</span>
            </a>
        </nav>
    </div>
    
    <div class="absolute bottom-0 w-64 p-6 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-3 text-gray-300 hover:text-white w-full px-4 py-2 rounded-lg hover:bg-[#6a1c32] transition">
                <span>🚪</span>
                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>


