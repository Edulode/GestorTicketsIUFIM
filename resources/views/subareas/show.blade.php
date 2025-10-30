@extends('layouts.authenticated')

@section('title', 'Detalles de la Subárea')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $subarea->subarea }}</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa de la subárea organizacional</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('subareas.edit', $subarea->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Subárea
                </a>
                <a href="{{ route('subareas.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal de la Subárea -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Básica -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-layer-group mr-2"></i>
                        Información de la Subárea
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre de la Subárea</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $subarea->subarea }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID de la Subárea</dt>
                            <dd class="mt-1 text-sm text-gray-900">#{{ $subarea->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tickets Asociados</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $subarea->tickets->count() }} ticket(s)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $subarea->created_at ? $subarea->created_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $subarea->updated_at ? $subarea->updated_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets de la Subárea -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets Asociados ({{ $subarea->tickets->count() }})
                        </h3>
                        <a href="{{ route('tickets.create') }}?subarea={{ $subarea->id }}" 
                           class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            Crear Ticket
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($subarea->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($subarea->tickets->take(10) as $ticket)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    #{{ $ticket->id }} - {{ $ticket->asunto->asunto ?? 'Sin asunto' }}
                                                </h4>
                                                @if($ticket->status)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $ticket->status->status == 'Resuelto' ? 'bg-green-100 text-green-800' : 
                                                       ($ticket->status->status == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800') }}">
                                                    {{ $ticket->status->status }}
                                                </span>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($ticket->solicitud ?? 'Sin descripción', 100) }}</p>
                                            <div class="mt-2 flex items-center text-xs text-gray-500 space-x-4">
                                                <span>
                                                    <i class="fas fa-user mr-1"></i>
                                                    {{ $ticket->usuario ? ($ticket->usuario->nombre . ' ' . $ticket->usuario->apellido_paterno) : 'Usuario desconocido' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                                </span>
                                                @if($ticket->tipo)
                                                <span>
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $ticket->tipo->tipo }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                                               class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-eye mr-1"></i>
                                                Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($subarea->tickets->count() > 10)
                                <div class="text-center py-4">
                                    <a href="{{ route('tickets.index') }}?subarea={{ $subarea->id }}" 
                                       class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                        Ver todos los tickets ({{ $subarea->tickets->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No hay tickets registrados para esta subárea.</p>
                            <div class="mt-4">
                                <a href="{{ route('tickets.create') }}?subarea={{ $subarea->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Crear Primer Ticket
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Panel Lateral de Estadísticas -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Estadísticas Generales -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas de la Subárea
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total de Tickets</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $subarea->tickets->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tickets Pendientes</span>
                            <span class="text-lg font-semibold text-yellow-600">
                                {{ $subarea->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Pendiente'; })->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tickets Resueltos</span>
                            <span class="text-lg font-semibold text-green-600">
                                {{ $subarea->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Resuelto'; })->count() }}
                            </span>
                        </div>
                        @if($subarea->tickets->count() > 0)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tasa de Resolución</span>
                            <span class="text-lg font-semibold text-purple-600">
                                {{ round(($subarea->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Resuelto'; })->count() / $subarea->tickets->count()) * 100, 1) }}%
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('tickets.create') }}?subarea={{ $subarea->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Ticket
                        </a>
                        <a href="{{ route('subareas.edit', $subarea->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Información
                        </a>
                        <a href="{{ route('tickets.index') }}?subarea={{ $subarea->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-list mr-2"></i>
                            Ver Todos los Tickets
                        </a>
                    </div>
                </div>
            </div>

            <!-- Información de Contexto -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Ubicación Organizacional
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-layer-group text-purple-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Subárea:</span>
                            <span class="ml-2 text-gray-900">{{ $subarea->subarea }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-hashtag text-gray-500 mr-3"></i>
                            <span class="font-medium text-gray-700">ID:</span>
                            <span class="ml-2 text-gray-900">#{{ $subarea->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
