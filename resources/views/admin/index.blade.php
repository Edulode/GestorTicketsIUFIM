@extends('layouts.authenticated')

@section('title', 'Panel de Administración')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Panel de Administración</h1>
        <p class="mt-2 text-sm text-gray-700">Gestión del sistema de tickets</p>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
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
                            <dd class="text-lg font-medium text-gray-900">{{ $totalTickets }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $ticketsPendientes }}</dd>
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
                            <i class="fas fa-check-circle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Resueltos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $ticketsResueltos }}</dd>
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
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Usuarios</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalUsuarios }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-building text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Áreas</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalAreas }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    

    <!-- Módulos de Configuración -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                <i class="fas fa-cogs mr-2 text-gray-600"></i>
                Configuración del Sistema
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
                <a href="{{ route('areas.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-building text-blue-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Áreas</h4>
                            <p class="text-sm text-gray-500">Gestionar áreas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('subareas.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-green-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Subáreas</h4>
                            <p class="text-sm text-gray-500">Ubicaciones específicas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('tecnicos.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-tools text-purple-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Técnicos</h4>
                            <p class="text-sm text-gray-500">Personal técnico</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('categorias-servicio.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-tags text-red-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Categorías</h4>
                            <p class="text-sm text-gray-500">Tipos de servicio</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('tipos_solicitud.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-clipboard-list text-indigo-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Tipos Solicitud</h4>
                            <p class="text-sm text-gray-500">Clasificación de tickets</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('usuarios.index') }}" 
                   class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-users text-indigo-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Usuarios</h4>
                            <p class="text-sm text-gray-500">Gestión de usuarios</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
