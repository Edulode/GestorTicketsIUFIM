@extends('layouts.authenticated')

@section('title', 'Detalles del Tipo de Solicitud')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $tipoSolicitud->tipo_solicitud }}</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa del tipo de solicitud</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tipos_solicitud.edit', $tipoSolicitud->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Tipo
                </a>
                @if($tipoSolicitud->tickets->count() == 0)
                    <form action="{{ route('tipos_solicitud.destroy', $tipoSolicitud->id) }}" 
                          method="POST" 
                          class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 delete-button" 
                                data-tipo="{{ $tipoSolicitud->tipo_solicitud }}">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Tipo
                        </button>
                    </form>
                @else
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-500 bg-gray-100 cursor-not-allowed" 
                            title="No se puede eliminar: tiene {{ $tipoSolicitud->tickets->count() }} ticket(s) asociado(s)"
                            disabled>
                        <i class="fas fa-lock mr-2"></i>
                        No Eliminable
                    </button>
                @endif
                <a href="{{ route('tipos_solicitud.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Básica -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        Información del Tipo de Solicitud
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre del Tipo</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $tipoSolicitud->tipo_solicitud }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID del Tipo</dt>
                            <dd class="mt-1 text-sm text-gray-900">#{{ $tipoSolicitud->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Categoría de Servicio</dt>
                            <dd class="mt-1">
                                @if($tipoSolicitud->categoriaServicio)
                                    <a href="{{ route('categorias-servicio.show', $tipoSolicitud->categoriaServicio->id) }}" 
                                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-folder-open mr-2"></i>
                                        {{ $tipoSolicitud->categoriaServicio->categoria_servicio }}
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-minus mr-2"></i>
                                        Sin categoría asignada
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tickets Asociados</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $tipoSolicitud->tickets->count() }} ticket(s)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $tipoSolicitud->created_at ? $tipoSolicitud->created_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $tipoSolicitud->updated_at ? $tipoSolicitud->updated_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets del Tipo de Solicitud -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets Asociados ({{ $tipoSolicitud->tickets->count() }})
                        </h3>
                        <a href="{{ route('tickets.create') }}?tipo={{ $tipoSolicitud->id }}" 
                           class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            Crear Ticket
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($tipoSolicitud->tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($tipoSolicitud->tickets->take(10) as $ticket)
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
                                                @if($ticket->subarea)
                                                <span>
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ $ticket->subarea->subarea }}
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
                            @if($tipoSolicitud->tickets->count() > 10)
                                <div class="text-center py-4">
                                    <a href="{{ route('tickets.index') }}?tipo={{ $tipoSolicitud->id }}" 
                                       class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                        Ver todos los tickets ({{ $tipoSolicitud->tickets->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No hay tickets registrados para este tipo de solicitud.</p>
                            <div class="mt-4">
                                <a href="{{ route('tickets.create') }}?tipo={{ $tipoSolicitud->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Crear Primer Ticket
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Información de la Categoría -->
            @if($tipoSolicitud->categoriaServicio)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-folder-open mr-2"></i>
                            Información de la Categoría
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-folder-open text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $tipoSolicitud->categoriaServicio->categoria_servicio }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $tipoSolicitud->categoriaServicio->tiposSolicitud->count() }} tipo(s) de solicitud • 
                                        {{ $tipoSolicitud->categoriaServicio->tickets->count() }} ticket(s) total
                                    </p>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('categorias-servicio.show', $tipoSolicitud->categoriaServicio->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Ver Categoría Completa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Lateral de Estadísticas -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Estadísticas Generales -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas del Tipo
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total de Tickets</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $tipoSolicitud->tickets->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tickets Pendientes</span>
                            <span class="text-lg font-semibold text-yellow-600">
                                {{ $tipoSolicitud->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Pendiente'; })->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tickets Resueltos</span>
                            <span class="text-lg font-semibold text-green-600">
                                {{ $tipoSolicitud->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Resuelto'; })->count() }}
                            </span>
                        </div>
                        @if($tipoSolicitud->tickets->count() > 0)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tasa de Resolución</span>
                            <span class="text-lg font-semibold text-purple-600">
                                {{ round(($tipoSolicitud->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status == 'Resuelto'; })->count() / $tipoSolicitud->tickets->count()) * 100, 1) }}%
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
                        <a href="{{ route('tickets.create') }}?tipo={{ $tipoSolicitud->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Ticket
                        </a>
                        <a href="{{ route('tipos_solicitud.edit', $tipoSolicitud->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Información
                        </a>
                        @if($tipoSolicitud->categoriaServicio)
                            <a href="{{ route('categorias-servicio.show', $tipoSolicitud->categoriaServicio->id) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-folder-open mr-2"></i>
                                Ver Categoría
                            </a>
                        @endif
                        <a href="{{ route('tickets.index') }}?tipo={{ $tipoSolicitud->id }}" 
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
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-hashtag text-gray-500 mr-3"></i>
                            <span class="font-medium text-gray-700">ID:</span>
                            <span class="ml-2 text-gray-900">#{{ $tipoSolicitud->id }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-clipboard-list text-blue-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Tipo:</span>
                            <span class="ml-2 text-gray-900">{{ $tipoSolicitud->tipo_solicitud }}</span>
                        </div>
                        @if($tipoSolicitud->categoriaServicio)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-folder-open text-purple-500 mr-3"></i>
                                <span class="font-medium text-gray-700">Categoría:</span>
                                <span class="ml-2 text-gray-900">{{ $tipoSolicitud->categoriaServicio->categoria_servicio }}</span>
                            </div>
                        @endif
                        <div class="flex items-center text-sm">
                            <i class="fas fa-ticket-alt text-green-500 mr-3"></i>
                            <span class="font-medium text-gray-700">Tickets:</span>
                            <span class="ml-2 text-gray-900">{{ $tipoSolicitud->tickets->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Icono de advertencia -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            
            <!-- Título -->
            <h3 class="text-lg font-medium text-gray-900 text-center mb-2">
                Confirmar Eliminación
            </h3>
            
            <!-- Mensaje -->
            <div class="text-sm text-gray-500 text-center mb-6">
                <p class="mb-2">Está a punto de eliminar el tipo de solicitud:</p>
                <p class="font-semibold text-gray-900" id="tipoToDelete"></p>
                <p class="mt-2 text-red-600">⚠️ Esta acción es permanente e irreversible</p>
                <p class="mt-1 text-xs text-gray-500">Se eliminará toda la información asociada</p>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-center space-x-3">
                <button type="button" 
                        id="cancelDelete"
                        class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button type="button" 
                        id="confirmDelete"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar Definitivamente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para modal de eliminación -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables del modal
    const deleteModal = document.getElementById('deleteModal');
    const tipoToDelete = document.getElementById('tipoToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const deleteButton = document.querySelector('.delete-button');
    let currentForm = null;
    
    // Solo agregar evento si existe el botón de eliminar
    if (deleteButton) {
        // Abrir modal de confirmación
        deleteButton.addEventListener('click', function() {
            const tipo = this.getAttribute('data-tipo');
            currentForm = this.closest('.delete-form');
            
            tipoToDelete.textContent = tipo;
            deleteModal.classList.remove('hidden');
            
            // Animación de entrada
            setTimeout(() => {
                deleteModal.querySelector('.relative').style.transform = 'scale(1)';
                deleteModal.querySelector('.relative').style.opacity = '1';
            }, 10);
        });
    }
    
    // Confirmar eliminación
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentForm) {
            // Cambiar a estado de carga
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            this.disabled = true;
            
            // Enviar formulario
            currentForm.submit();
        }
    });
    
    // Cancelar eliminación
    function closeModal() {
        deleteModal.querySelector('.relative').style.transform = 'scale(0.9)';
        deleteModal.querySelector('.relative').style.opacity = '0';
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            currentForm = null;
            confirmDeleteBtn.innerHTML = '<i class="fas fa-trash mr-2"></i>Eliminar Definitivamente';
            confirmDeleteBtn.disabled = false;
        }, 200);
    }
    
    cancelDeleteBtn.addEventListener('click', closeModal);
    
    // Cerrar modal al hacer clic fuera
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeModal();
        }
    });
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Estilo inicial del modal
    deleteModal.querySelector('.relative').style.transform = 'scale(0.9)';
    deleteModal.querySelector('.relative').style.opacity = '0';
    deleteModal.querySelector('.relative').style.transition = 'all 0.2s ease-out';
});
</script>
@endsection
