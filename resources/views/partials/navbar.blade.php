<nav class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
    <div>
        <h1 class="text-xl font-semibold text-[#3c3c3b]">@yield('page-title', 'Dashboard')</h1>
    </div>
    
    <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
        <div class="w-10 h-10 rounded-full bg-[#b17a45] flex items-center justify-center text-white font-bold">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
    </div>
</nav>
