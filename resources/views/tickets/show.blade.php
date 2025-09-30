@extends('layouts.authenticated')

@section('title', 'Detalles del Ticket #' . $ticket->id)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tickets.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Ticket #{{ $ticket->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Creado el {{ $ticket->created_at->format('d/m/Y \a \l\a\s H:i') }}
                        @if($ticket->updated_at != $ticket->created_at)
                            • Actualizado el {{ $ticket->updated_at->format('d/m/Y \a \l\a\s H:i') }}
                        @endif
                    </p>
                </div>
            </div>
            
            <!-- Botones de Acción -->
            <div class="flex items-center space-x-3">
                <!-- Botón Marcar como Resuelto -->
                @if($ticket->status && $ticket->status->status !== 'Resuelto')
                    <form action="{{ route('tickets.markAsResolved', $ticket->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                onclick="return confirm('¿Estás seguro de que quieres marcar este ticket como resuelto?')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                            <i class="fas fa-check mr-2"></i>
                            Marcar como Resuelto
                        </button>
                    </form>
                @endif
                
                <!-- Botón Editar -->
                <a href="{{ route('tickets.edit', $ticket->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                
                <!-- Botón Eliminar -->
                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('¿Estás seguro de que quieres eliminar este ticket? Esta acción no se puede deshacer.')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Información del Estado y Prioridad -->
    <div class="mb-6 flex items-center space-x-4">
        <!-- Estado -->
        <div class="flex items-center">
            <span class="text-sm font-medium text-gray-700 mr-2">Estado:</span>
            @if($ticket->status)
                @php
                    $statusColors = [
                        'Pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'Resuelto' => 'bg-green-100 text-green-800 border-green-200'
                    ];
                    $colorClass = $statusColors[$ticket->status->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $colorClass }}">
                    <i class="fas fa-circle mr-2" style="font-size: 8px;"></i>
                    {{ $ticket->status->status }}
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border bg-gray-100 text-gray-800 border-gray-200">
                    <i class="fas fa-question-circle mr-2"></i>
                    Sin Estado
                </span>
            @endif
        </div>

        <!-- Técnico Asignado -->
        @if($ticket->tecnico)
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-700 mr-2">Técnico:</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 border border-purple-200">
                    <i class="fas fa-user-cog mr-2"></i>
                    {{ $ticket->tecnico->nombre . ' ' . $ticket->tecnico->apellidoP . ' ' . $ticket->tecnico->apellidoM }}
                </span>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal del Ticket -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles de la Solicitud -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-ticket-alt mr-2 text-blue-600"></i>
                        Detalles de la Solicitud
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Solicitud</label>
                        <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                            {{ $ticket->solicitud }}
                        </div>
                    </div>

                    @if($ticket->incidencia_real)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Incidencia Real</label>
                            <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                                {{ $ticket->incidencia_real }}
                            </div>
                        </div>
                    @endif

                    @if($ticket->servicio_realizado)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Servicio Realizado</label>
                            <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                                {{ $ticket->servicio_realizado }}
                            </div>
                        </div>
                    @endif

                    @if($ticket->notas)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                            <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                                {{ $ticket->notas }}
                            </div>
                        </div>
                    @endif

                    @if($ticket->observaciones)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                            <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                                {{ $ticket->observaciones }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información del Usuario -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Información del Solicitante
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                            <p class="text-sm text-gray-900">{{ $ticket->usuario->nombre . " " . $ticket->usuario->apellido_paterno . " " . $ticket->usuario->apellido_materno ?? 'No especificado' }}</p>
                        </div>
                        @if($ticket->usuario && $ticket->usuario->email)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-sm text-gray-900">{{ $ticket->usuario->email }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <p class="text-sm text-gray-900">{{ $ticket->area->nombre ?? 'No especificada' }}</p>
                        </div>
                        @if($ticket->subarea)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lugar de Incidencia</label>
                                <p class="text-sm text-gray-900">{{ $ticket->subarea->subarea }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="space-y-6">
            <!-- Información Técnica -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-cogs mr-2 text-purple-600"></i>
                        Información Técnica
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">ID del Ticket:</span>
                        <span class="text-sm text-gray-900">#{{ $ticket->id }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Ciclo:</span>
                        <span class="text-sm text-gray-900">{{ $ticket->ciclo->ciclo ?? 'No especificado' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Tipo:</span>
                        <span class="text-sm text-gray-900">{{ $ticket->tipo->tipo ?? 'No especificado' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Asunto:</span>
                        <span class="text-sm text-gray-900">{{ $ticket->asunto->asunto ?? 'No especificado' }}</span>
                    </div>

                    @if($ticket->tipoSolicitud)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Tipo Solicitud:</span>
                            <span class="text-sm text-gray-900">{{ $ticket->tipoSolicitud->tipo_solicitud }}</span>
                        </div>
                    @endif

                    @if($ticket->categoriaServicio)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Categoría:</span>
                            <span class="text-sm text-gray-900">{{ $ticket->categoriaServicio->categoria_servicio }}</span>
                        </div>
                    @endif

                    @if($ticket->tecnico)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Técnico:</span>
                            <span class="text-sm text-gray-900">{{ $ticket->tecnico->nombre . ' ' . $ticket->tecnico->apellidoP . ' ' . $ticket->tecnico->apellidoM }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Fechas Importantes -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-calendar-alt mr-2 text-orange-600"></i>
                        Fechas Importantes
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700 block">Fecha de Creación</span>
                        <span class="text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($ticket->fecha)
                        <div>
                            <span class="text-sm font-medium text-gray-700 block">Fecha del Incidente</span>
                            <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->fecha)->format('d/m/Y') }}</span>
                        </div>
                    @endif

                    @if($ticket->fecha_atencion)
                        <div>
                            <span class="text-sm font-medium text-gray-700 block">Fecha de Atención</span>
                            <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($ticket->fecha_atencion)->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif

                    <div>
                        <span class="text-sm font-medium text-gray-700 block">Última Actualización</span>
                        <span class="text-sm text-gray-900">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('tickets.edit', $ticket->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Ticket
                    </a>

                    @if($ticket->status && $ticket->status->status !== 'Resuelto')
                        <form action="{{ route('tickets.markAsResolved', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    onclick="return confirm('¿Estás seguro de que quieres marcar este ticket como resuelto?')"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Marcar como Resuelto
                            </button>
                        </form>
                    @endif

                    <button type="button" 
                            onclick="window.print()"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-print mr-2"></i>
                        Imprimir Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para impresión -->
<style media="print">
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .shadow, .border {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
</style>

<!-- JavaScript para funcionalidades adicionales -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmaciones para acciones críticas
    const deleteButtons = document.querySelectorAll('form[action*="destroy"] button[type="submit"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que quieres eliminar este ticket? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });

    const resolveButtons = document.querySelectorAll('form[action*="markAsResolved"] button[type="submit"]');
    resolveButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que quieres marcar este ticket como resuelto?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection
