<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Baja Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a1c32 0%, #993233 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 1rem;
        }
        
        .login-card {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 login-card">
        {{-- LOGO DE AGRICULTURA --}}
        <div class="text-center mb-6">
            <img src="{{ asset('images/AGRICULTURA-02.png') }}" 
                 alt="Secretaría de Agricultura" 
                 class="h-20 md:h-24 w-auto mx-auto object-contain"
                 >
        </div>
        
        {{-- SEPARADOR DECORATIVO --}}
        <div class="flex items-center justify-center mb-6">
            <div class="h-px bg-gray-300 flex-1"></div>
            <span class="px-3 text-xs text-gray-400 uppercase tracking-wider">Acceso Administrativo</span>
            <div class="h-px bg-gray-300 flex-1"></div>
        </div>
        
        {{-- TÍTULO --}}
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-[#3c3c3b]">Baja Market</h2>
            <p class="text-gray-500 text-xs mt-0.5">Directorio Agroindustrial</p>
        </div>
        
        {{-- ERRORES --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-start gap-2">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        
        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-600 mb-1.5 uppercase tracking-wide">Correo Electrónico</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@bajamarket.com"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent transition">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-600 mb-1.5 uppercase tracking-wide">Contraseña</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </span>
                    <input type="password" name="password" required id="password"
                           placeholder="••••••••"
                           class="w-full pl-10 pr-12 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#6a1c32] focus:border-transparent transition">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#6a1c32] focus:ring-[#6a1c32] w-4 h-4">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
                
                {{-- Olvidé contraseña (opcional) --}}
                {{-- <a href="#" class="text-xs text-[#b17a45] hover:underline">¿Olvidaste tu contraseña?</a> --}}
            </div>
            
            <button type="submit" 
                    class="w-full py-2.5 px-4 bg-gradient-to-r from-[#6a1c32] to-[#993233] text-white rounded-lg font-medium hover:from-[#7a2038] hover:to-[#a93838] transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Iniciar Sesión
            </button>
        </form>
        
        {{-- VOLVER AL SITIO --}}
        <div class="mt-6 text-center">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-1 text-sm text-[#b17a45] hover:text-[#6a1c32] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al sitio
            </a>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                password.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>
</html>



