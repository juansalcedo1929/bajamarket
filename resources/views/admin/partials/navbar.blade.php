<nav class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
    <div>
        <h1 class="text-xl font-semibold text-[#3c3c3b]">@yield('page-title', 'Dashboard')</h1>
    </div>
    
    {{-- DROPDOWN DE USUARIO CON CERRAR SESIÓN --}}
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" 
                class="flex items-center space-x-3 text-gray-700 hover:text-[#6a1c32] transition">
            <span class="text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        {{-- MENÚ DESPLEGABLE --}}
        <div x-show="open" 
             @click.away="open = false"
             x-transition
             x-cloak
             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-100 z-50">
            <div class="px-4 py-2 border-b border-gray-100">
                <p class="text-xs text-gray-500">Sesión iniciada como</p>
                <p class="text-sm font-medium text-[#3c3c3b]">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
            </div>
  
            <div class="border-t border-gray-100 my-1"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</nav>
