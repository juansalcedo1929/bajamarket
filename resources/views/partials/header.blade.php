<header class="bg-white shadow-sm sticky top-0 z-40">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo y Nombre -->
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                    {{-- LOGO DE AGRICULTURA --}}
                    <img src="{{ asset('images/AGRICULTURA-02.png') }}" 
                         alt="Secretaría de Agricultura" 
                         class="h-12 md:h-14 w-auto object-contain"
                         onerror="this.style.display='none'">
                    
                    <div class="flex items-center space-x-2">
                   
                    
                    </div>
                </a>
            </div>
            
            <!-- Navegación Desktop -->
            <nav class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('landing') }}" 
                   class="text-gray-700 hover:text-[#6a1c32] font-medium transition {{ request()->routeIs('landing') ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : '' }}">
                    Inicio
                </a>
                <a href="{{ route('catalogo.index') }}" 
                   class="text-gray-700 hover:text-[#6a1c32] font-medium transition {{ request()->routeIs('catalogo.*') ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : '' }}">
                    Catálogo
                </a>
                <a href="{{ route('directorio.index') }}" 
                   class="text-gray-700 hover:text-[#6a1c32] font-medium transition {{ request()->routeIs('directorio.*') ? 'text-[#6a1c32] border-b-2 border-[#6a1c32]' : '' }}">
                    Directorio
                </a>
            </nav>
            
            <!-- Botones de acción -->
            <div class="flex items-center space-x-2 md:space-x-3">
                <a href="{{ route('registro.create') }}" 
                   class="hidden lg:block px-4 py-2 rounded-lg text-white font-medium transition bg-[#6a1c32] hover:bg-[#993233] shadow-md hover:shadow-lg text-sm">
                    Registrar Productor
                </a>
                
                @auth
                    {{-- DROPDOWN CON CERRAR SESIÓN --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 text-gray-700 hover:text-[#6a1c32] transition">
                            <span class="hidden md:inline text-sm">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#6a1c32] to-[#b17a45] flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-100 z-50">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#6a1c32]">
                                📊 Panel Admin
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    🚪 Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="hidden md:block px-4 py-2 border border-[#6a1c32] text-[#6a1c32] rounded-lg font-medium hover:bg-[#6a1c32] hover:text-white transition text-sm">
                        Iniciar sesión
                    </a>
                @endauth
                
                <!-- Botón menú móvil -->
                <button onclick="openMobileMenu()" 
                        class="md:hidden p-2 text-gray-600 hover:text-[#6a1c32] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>