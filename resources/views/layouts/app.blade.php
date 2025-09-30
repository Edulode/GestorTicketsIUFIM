<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <title>@yield('title', 'Soporte Técnico Instituto Universitario Franco Ingles de Mexico')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
                <div class="flex justify-between h-25">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gray-900">
                                <a href="{{ route('tickets.create') }}">
                                    <img src="/images/logo.png" alt="Instituto Universitario Franco Ingles de Mexico logo showing a stylized crest with blue and gold colors, conveying a formal and welcoming atmosphere, placed in a bright and clean header environment" class="h-20" />
                                </a>
                            </h1>
                        </div>
                    </div>
                    <div class="ml-4 text-lg font-semibold text-gray-700 text-center">
                            <div class="flex justify-center items-center h-20">
                                Soporte Técnico IUFIM
                            </div>
                    </div>
                        <!-- User menu -->
                    <div class="flex items-center space-x-4">

                        <form method="GET" action="{{ route('login') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Iniciar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
