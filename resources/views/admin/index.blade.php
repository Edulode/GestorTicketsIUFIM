@extends('layouts.authenticated')

@section('title', 'Panel de Administración')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['tickets'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Usuarios</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['usuarios'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-building text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Áreas</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['areas'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Técnicos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['tecnicos'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CRUD Menu Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Gestión de Usuarios -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Usuarios</h3>
                        <p class="text-sm text-gray-500">{{ $stats['usuarios'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona los usuarios del sistema</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('usuarios.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('usuarios.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-blue-600 text-sm leading-4 font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Áreas -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Áreas</h3>
                        <p class="text-sm text-gray-500">{{ $stats['areas'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona las áreas organizacionales</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('areas.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('areas.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-green-600 text-sm leading-4 font-medium rounded-md text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Subáreas -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sitemap text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Lugares de inicidencia</h3>
                        <p class="text-sm text-gray-500">{{ $stats['subareas'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona los lugares de incidencia de cada área</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('subareas.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('subareas.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-purple-600 text-sm leading-4 font-medium rounded-md text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Técnicos -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tools text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Técnicos</h3>
                        <p class="text-sm text-gray-500">{{ $stats['tecnicos'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona el personal técnico</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('tecnicos.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('tecnicos.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-orange-600 text-sm leading-4 font-medium rounded-md text-orange-600 bg-white hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Ciclos -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Ciclos</h3>
                        <p class="text-sm text-gray-500">{{ $stats['ciclos'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona los ciclos temporales</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('ciclos.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('ciclos.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-indigo-600 text-sm leading-4 font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Tipos de Solicitud -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tags text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Tipos de Solicitud</h3>
                        <p class="text-sm text-gray-500">{{ $stats['tipo_solicitudes'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona los tipos de solicitud</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('tipos_solicitud.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('tipos_solicitud.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-red-600 text-sm leading-4 font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Gestión de Categorías de Servicio -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-layer-group text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-medium text-gray-900">Categorías de Servicio</h3>
                        <p class="text-sm text-gray-500">{{ $stats['categoria_servicios'] }} registros</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-4">Gestiona las categorías de servicio</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('categorias-servicio.index') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-list mr-1"></i>
                            Ver
                        </a>
                        <a href="{{ route('categorias-servicio.create') }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-yellow-600 text-sm leading-4 font-medium rounded-md text-yellow-600 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection