@extends('layouts.authenticated')

@section('title', 'Detalles del Ciclo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $ciclo->ciclo }}</h1>
                <p class="mt-2 text-sm text-gray-700">Información detallada del ciclo académico</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('ciclos.edit', $ciclo) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
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
                        Información Básica
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre del Ciclo</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $ciclo->ciclo }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID del Sistema</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($ciclo->id, 4, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Temporal -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-clock mr-2"></i>
                        Información Temporal
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ciclo->created_at ? $ciclo->created_at->format('d/m/Y H:i:s') : 'No disponible' }}
                            </dd>
                            @if($ciclo->created_at)
                                <dd class="text-xs text-gray-500">
                                    {{ $ciclo->created_at->diffForHumans() }}
                                </dd>
                            @endif
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ciclo->updated_at ? $ciclo->updated_at->format('d/m/Y H:i:s') : 'No disponible' }}
                            </dd>
                            @if($ciclo->updated_at)
                                <dd class="text-xs text-gray-500">
                                    {{ $ciclo->updated_at->diffForHumans() }}
                                </dd>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Asociados -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets Asociados
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $ciclo->tickets->count() }} tickets
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    @if($ciclo->tickets->count() > 0)
                        <div class="space-y-3">
                            @foreach($ciclo->tickets->take(5) as $ticket)
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
                                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($ticket->descripcion ?? 'Sin descripción', 80) }}</p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Creado: {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y') : 'No disponible' }}
                                            </p>
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
                            
                            @if($ciclo->tickets->count() > 5)
                                <div class="text-center pt-4">
                                    <a href="{{ route('tickets.index') }}?ciclo={{ $ciclo->id }}" 
                                       class="text-sm text-blue-600 hover:text-blue-900">
                                        Ver todos los {{ $ciclo->tickets->count() }} tickets →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-ticket-alt text-gray-400 text-3xl mb-4"></i>
                            <p class="text-gray-500">No hay tickets asociados a este ciclo</p>
                            <p class="text-sm text-gray-400 mt-1">Los tickets aparecerán aquí cuando se asignen a este ciclo</p>
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
                            <span class="text-lg font-semibold text-blue-600">{{ $ciclo->tickets->count() }}</span>
                        </div>
                        
                        <!-- Tickets por Estado -->
                        @php
                            $ticketsAbiertos = $ciclo->tickets->whereHas('status', function($q) { $q->where('status', 'Abierto'); })->count();
                            $ticketsEnProceso = $ciclo->tickets->whereHas('status', function($q) { $q->where('status', 'En Proceso'); })->count();
                            $ticketsCerrados = $ciclo->tickets->whereHas('status', function($q) { $q->where('status', 'Cerrado'); })->count();
                        @endphp
                        
                        <div class="border-t pt-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Abiertos</span>
                                <span class="text-sm font-medium text-green-600">{{ $ticketsAbiertos }}</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">En Proceso</span>
                                <span class="text-sm font-medium text-yellow-600">{{ $ticketsEnProceso }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Cerrados</span>
                                <span class="text-sm font-medium text-gray-600">{{ $ticketsCerrados }}</span>
                            </div>
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
                    <a href="{{ route('ciclos.edit', $ciclo) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Ciclo
                    </a>
                    
                    @if($ciclo->tickets->count() > 0)
                        <a href="{{ route('tickets.index') }}?ciclo={{ $ciclo->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Ver Todos los Tickets
                        </a>
                    @endif
                    
                    <button type="button" onclick="showDeleteModal()" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Ciclo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        ¿Estás seguro de que deseas eliminar el ciclo <strong>"{{ $ciclo->ciclo }}"</strong>?
                    </p>
                    @if($ciclo->tickets->count() > 0)
                        <div class="mt-3 p-3 bg-red-50 rounded-md">
                            <p class="text-sm text-red-800">
                                <strong>¡Atención!</strong> Este ciclo tiene {{ $ciclo->tickets->count() }} ticket(s) asociado(s). 
                                No se puede eliminar mientras tenga tickets vinculados.
                            </p>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mt-2">
                            Esta acción no se puede deshacer.
                        </p>
                    @endif
                </div>
                <div class="flex justify-center space-x-3 mt-6">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    @if($ciclo->tickets->count() == 0)
                        <form action="{{ route('ciclos.destroy', $ciclo) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Sí, Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection
