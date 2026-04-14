<!-- Mobile Menu -->
<div id="mobileMenu" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeMobileMenu()">
    <div class="bg-white w-64 h-full p-6" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-xl font-bold text-[#6a1c32]">Baja Market</h3>
            <button onclick="closeMobileMenu()" class="text-gray-600 text-2xl">&times;</button>
        </div>
        
        <nav class="space-y-4">
            <a href="{{ route('landing') }}" class="block py-2 text-gray-700 hover:text-[#6a1c32] font-medium transition">
                Inicio
            </a>
            <a href="{{ route('catalogo.index') }}" class="block py-2 text-gray-700 hover:text-[#6a1c32] font-medium transition">
                Catálogo
            </a>
            <a href="{{ route('directorio.index') }}" class="block py-2 text-gray-700 hover:text-[#6a1c32] font-medium transition">
                Directorio
            </a>
            <a href="{{ route('registro.create') }}" class="block py-2 text-[#6a1c32] font-medium">
                Registrar Productor
            </a>
            
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 hover:text-[#6a1c32] font-medium">
                    Panel Admin
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 text-red-600 hover:text-red-800 font-medium">
                        Cerrar sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-[#6a1c32] font-medium">
                    Iniciar sesión
                </a>
            @endauth
        </nav>
    </div>
</div>

<script>
    function openMobileMenu() {
        document.getElementById('mobileMenu').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileMenu() {
        document.getElementById('mobileMenu').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>



