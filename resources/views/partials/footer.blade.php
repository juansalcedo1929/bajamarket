<footer class="text-white mt-16" style="background-color: #3c3c3b;">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Logo y descripción -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #6a1c32;">
                        <span class="text-white font-bold text-xl">B</span>
                    </div>
                    <h3 class="text-xl font-bold">Baja Market</h3>
                </div>
                <p class="text-gray-400 text-sm">
                    Conectando productores agroindustriales de Baja California con compradores de todo México.
                </p>
            </div>
            
            <!-- Enlaces rápidos -->
            <div>
                <h4 class="font-semibold mb-4" style="color: #b17a45;">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('catalogo.index') }}" class="hover:text-white transition">Catálogo de Productos</a></li>
                    <li><a href="{{ route('directorio.index') }}" class="hover:text-white transition">Directorio de Productores</a></li>
                    <li><a href="{{ route('registro.create') }}" class="hover:text-white transition">Registrar Productor</a></li>
                    <li><a href="#" class="hover:text-white transition">Términos y Condiciones</a></li>
                </ul>
            </div>
            
            <!-- Municipios -->
            <div>
                <h4 class="font-semibold mb-4" style="color: #b17a45;">Municipios</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Ensenada</li>
                    <li>Mexicali</li>
                    <li>Tecate</li>
                    <li>Tijuana</li>
                    <li>Playas de Rosarito</li>
                    <li>San Quintín</li>
                    <li>San Felipe</li>
                </ul>
            </div>
            
            <!-- Contacto -->
            <div>
                <h4 class="font-semibold mb-4" style="color: #b17a45;">Contacto</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>contacto@bajamarket.com</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>(686) 123-4567</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Baja Market. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>



