<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestor de Tickets IUFIM')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo y navegación principal -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo IUFIM" class="h-10 w-auto">
                        </div>
                        <div class="ml-4">
                            <h1 class="text-xl font-bold text-gray-900">
                                Sistema de Tickets IUFIM
                            </h1>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('tickets.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tickets.index') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i>
                            Tickets
                        </a>
                        <a href="{{ route('admin.dashboard')}}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium transition-colors duration-200">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Estadísticas
                        </a>
                        <a href="{{ route('admin.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.index') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium transition-colors duration-200">
                            <i class="fas fa-cogs mr-2"></i>
                            Base de datos
                        </a>
                    </div>
                    
                    <!-- User menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button type="button" class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                
                            </button>
                        </div>
                        
                        <!-- User dropdown -->
                        <div class="relative">
                            <button type="button" 
                                    class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                    onclick="toggleUserDropdown()">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <span class="ml-3 text-gray-700 text-sm font-medium">{{ Auth::user()->name ?? 'Usuario' }}</span>
                                <i class="ml-2 fas fa-chevron-down text-gray-400 text-xs"></i>
                            </button>
                            
                            <div id="user-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    
                                    <hr class="border-gray-200 my-1">
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="sm:hidden flex items-center">
                        <button type="button" 
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                onclick="toggleMobileMenu()">
                            <span class="sr-only">Abrir menú principal</span>
                            <i class="fas fa-bars" id="mobile-menu-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('tickets.index') }}" 
                       class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tickets.index') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        Tickets
                    </a>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tickets.create') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Estadísticas
                    </a>
                    <a href="{{ route('admin.index') }}" 
                       class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300 text-base font-medium transition-colors duration-200">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Base de datos
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name ?? 'Usuario' }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email ?? 'usuario@email.com' }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- JavaScript para el menú -->
    <script>
        function toggleUserDropdown() {
            const dropdown = document.getElementById('user-dropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            
            menu.classList.toggle('hidden');
            
            if (menu.classList.contains('hidden')) {
                icon.className = 'fas fa-bars';
            } else {
                icon.className = 'fas fa-times';
            }
        }

        // Cerrar dropdown cuando se hace click fuera
        document.addEventListener('click', function(event) {
            const userDropdown = document.getElementById('user-dropdown');
            const userButton = event.target.closest('[onclick="toggleUserDropdown()"]');
            
            if (!userButton && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
