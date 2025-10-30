@extends('layouts.authenticated')

@section('title', 'Detalles del Ciclo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $ciclo['nombre'] }}</h1>
                <p class="mt-2 text-sm text-gray-700">{{ $ciclo['codigo'] }} • {{ $ciclo['periodo'] }}</p>
            </div>
            <div class="flex space-x-3">
                @if($ciclo['codigo'] === $cicloActual['codigo'])
                    <span class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-50">
                        <i class="fas fa-star mr-2"></i>
                        Ciclo Actual
                    </span>
                @endif
                <a href="{{ route('ciclos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panel Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Básica -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Ciclo
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Código del Ciclo</dt>
                            <dd class="mt-1 text-lg text-gray-900 font-mono">{{ $ciclo['codigo'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $ciclo['nombre'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Período</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $ciclo['periodo'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Semestre</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ciclo['semestre'] }}° Semestre
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $ciclo['es_primer_semestre'] ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $ciclo['es_primer_semestre'] ? 'Primer Semestre' : 'Segundo Semestre' }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Temporal -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-calendar mr-2"></i>
                        Duración del Ciclo
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ciclo['fecha_inicio']->format('d/m/Y') }}
                            </dd>
                            <dd class="text-xs text-gray-500">
                                {{ $ciclo['fecha_inicio']->format('l, F j, Y') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Fin</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ciclo['fecha_fin']->format('d/m/Y') }}
                            </dd>
                            <dd class="text-xs text-gray-500">
                                {{ $ciclo['fecha_fin']->format('l, F j, Y') }}
                            </dd>
                        </div>
                    </div>
                    
                    @if($ciclo['codigo'] === $cicloActual['codigo'])
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-600 mr-3"></i>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-blue-800">Progreso del Ciclo Actual</h4>
                                    <div class="mt-2">
                                        <div class="bg-blue-200 rounded-full h-2">
                                            <div class="bg-blue-600 rounded-full h-2" style="width: {{ min(100, $cicloActual['progreso_porcentaje']) }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-blue-600 mt-1">
                                            <span>{{ number_format($cicloActual['progreso_porcentaje'], 1) }}% completado</span>
                                            <span>{{ $cicloActual['dias_restantes'] }} días restantes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tickets Asociados -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets del Ciclo
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $estadisticas['total_tickets'] }} tickets
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($tickets->count() > 0)
                        <div class="space-y-3">
                            @foreach($tickets as $ticket)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                                                </h4>
                                                @if($ticket->status)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        @if($ticket->status->status == 'Abierto') bg-green-100 text-green-800
                                                        @elseif($ticket->status->status == 'En Proceso') bg-yellow-100 text-yellow-800
                                                        @elseif($ticket->status->status == 'Cerrado') bg-gray-100 text-gray-800
                                                        @else bg-blue-100 text-blue-800
                                                        @endif">
                                                        {{ $ticket->status->status }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($ticket->solicitud ?? 'Sin descripción', 80) }}</p>
                                            <div class="mt-2 flex items-center text-xs text-gray-500 space-x-4">
                                                @if($ticket->area)
                                                    <span>
                                                        <i class="fas fa-building mr-1"></i>
                                                        {{ $ticket->area->area }}
                                                    </span>
                                                @endif
                                                @if($ticket->usuario)
                                                    <span>
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $ticket->usuario->nombre }}
                                                    </span>
                                                @endif
                                                <span>
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $ticket->fecha ? $ticket->fecha->format('d/m/Y') : 'No disponible' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('tickets.show', $ticket) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Paginación -->
                        @if($tickets->hasPages())
                            <div class="mt-6">
                                {{ $tickets->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-ticket-alt text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">No hay tickets asociados a este ciclo</p>
                            <p class="text-sm text-gray-400 mt-1">Los tickets aparecerán aquí cuando se creen durante este período</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Total de Tickets -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total de Tickets</span>
                            <span class="text-lg font-semibold text-blue-600">{{ $estadisticas['total_tickets'] }}</span>
                        </div>
                        
                        <!-- Tickets por Estado -->
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Abiertos</span>
                                <span class="text-sm font-medium text-green-600">{{ $estadisticas['tickets_abiertos'] }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">En Proceso</span>
                                <span class="text-sm font-medium text-yellow-600">{{ $estadisticas['tickets_proceso'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Cerrados</span>
                                <span class="text-sm font-medium text-gray-600">{{ $estadisticas['tickets_cerrados'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sistema Automático -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-cog mr-2"></i>
                        Sistema Automático
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                <span class="text-sm font-medium text-blue-800">Generado Automáticamente</span>
                            </div>
                            <p class="text-xs text-blue-600 mt-1">
                                Este ciclo se genera automáticamente basado en las fechas del sistema.
                            </p>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <p><strong>Regla aplicada:</strong></p>
                            <p class="mt-1">
                                @if($ciclo['es_primer_semestre'])
                                    Enero - Junio → Año + "B"
                                @else
                                    Julio - Diciembre → Año + "A"
                                @endif
                            </p>
                        </div>
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
                <div class="p-6 space-y-3">
                    @if($estadisticas['total_tickets'] > 0)
                        <a href="{{ route('tickets.index') }}?ciclo={{ $ciclo['codigo'] }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Ver Todos los Tickets
                        </a>
                    @endif
                    
                    <a href="{{ route('tickets.create') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Nuevo Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
