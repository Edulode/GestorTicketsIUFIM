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
                    <a href="{{ route('tickets.completado', $ticket->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                        <i class="fas fa-check mr-2"></i>
                        Marcar como Resuelto
                    </a>
                @endif
                
                <!-- Botón Editar -->
                <a href="{{ route('tickets.edit', $ticket->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                
                <!-- Botón Eliminar -->
                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            id="delete-button"
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
                            <p class="text-sm text-gray-900">
                                @if($ticket->usuario)
                                    {{ $ticket->usuario->nombre . " " . $ticket->usuario->apellido_paterno . " " . $ticket->usuario->apellido_materno }}
                                @else
                                    <span class="text-red-500">No hay usuario asociado (usuario_id: {{ $ticket->usuario_id ?? 'NULL' }})</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Área</label>
                            <p class="text-sm text-gray-900">
                                @if($ticket->area)
                                    {{ $ticket->area->area }}
                                @else
                                    <span class="text-red-500">No hay área asociada (area_id: {{ $ticket->area_id ?? 'NULL' }})</span>
                                @endif
                            </p>
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
                        <a href="{{ route('tickets.completado', $ticket->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>
                            Marcar como Resuelto
                        </a>
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

<!-- Estilos para impresión y modal profesional -->
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

<style>
    /* Estilos para modal de eliminación profesional */
    .modal-backdrop {
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }
    
    .modal-enter {
        animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .modal-danger {
        border-top: 4px solid #dc2626;
        background: linear-gradient(135deg, #ffffff 0%, #fef7f7 100%);
    }
    
    .danger-icon-container {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        transform: translateY(0);
        transition: all 0.2s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
    }
    
    .btn-cancel {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        transition: all 0.2s ease;
    }
    
    .btn-cancel:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .pulse-danger {
        animation: pulseDanger 2s infinite;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    @keyframes pulseDanger {
        0%, 100% { 
            box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4);
        }
        50% { 
            box-shadow: 0 0 0 10px rgba(220, 38, 38, 0);
        }
    }
</style>

<!-- JavaScript para modal profesional de eliminación -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal profesional para eliminación de tickets
    function showDeleteModal(ticketId, onConfirm, onCancel) {
        // Crear backdrop con blur avanzado
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fixed inset-0 bg-gray-900 bg-opacity-70 overflow-y-auto h-full w-full z-50 transition-all duration-300 opacity-0';
        
        // Crear modal con diseño de peligro
        const modal = document.createElement('div');
        modal.className = 'modal-enter modal-danger relative top-20 mx-auto p-0 border-0 w-96 shadow-2xl rounded-xl bg-white transform transition-all duration-400 scale-95';
        
        modal.innerHTML = `
            <div class="text-center p-6">
                <!-- Icono de peligro con animación -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full danger-icon-container mb-6 pulse-danger">
                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                
                <!-- Título principal -->
                <h3 class="text-xl leading-6 font-bold text-gray-900 mb-3">
                    Eliminar Ticket #${ticketId}
                </h3>
                
                <!-- Mensaje de advertencia -->
                <div class="mt-3 px-4 py-2">
                    <p class="text-base text-gray-700 mb-3 font-medium leading-relaxed">
                        ¿Está completamente seguro de que desea eliminar este ticket?
                    </p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                        <p class="text-sm text-red-700 leading-relaxed">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Esta acción es irreversible.</strong> Toda la información del ticket se perderá permanentemente.
                        </p>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Se eliminarán todos los datos asociados: descripción, fechas, asignaciones y historial completo.
                    </p>
                </div>
                
                <!-- Botones de acción -->
                <div class="flex justify-center space-x-4 mt-8">
                    <button id="modal-cancel" type="button" 
                            class="btn-cancel px-6 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-3 focus:ring-gray-300 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button id="modal-confirm" type="button" 
                            class="btn-danger px-6 py-3 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-3 focus:ring-red-300 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i>Eliminar Definitivamente
                    </button>
                </div>
            </div>
        `;
        
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        
        // Animación de entrada suave
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
            modal.classList.add('scale-100');
        }, 10);
        
        // Event listeners
        const confirmBtn = modal.querySelector('#modal-confirm');
        const cancelBtn = modal.querySelector('#modal-cancel');
        
        function closeModal() {
            backdrop.classList.add('opacity-0');
            modal.classList.remove('scale-100');
            modal.classList.add('scale-95');
            
            setTimeout(() => {
                if (document.body.contains(backdrop)) {
                    document.body.removeChild(backdrop);
                }
            }, 300);
        }
        
        confirmBtn.addEventListener('click', function() {
            // Cambiar botón a estado de carga
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            this.disabled = true;
            
            closeModal();
            if (onConfirm) onConfirm();
        });
        
        cancelBtn.addEventListener('click', function() {
            closeModal();
            if (onCancel) onCancel();
        });
        
        // Cerrar con ESC
        function handleEscape(e) {
            if (e.key === 'Escape') {
                closeModal();
                if (onCancel) onCancel();
                document.removeEventListener('keydown', handleEscape);
            }
        }
        document.addEventListener('keydown', handleEscape);
        
        // Cerrar al hacer clic en el backdrop
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) {
                closeModal();
                if (onCancel) onCancel();
            }
        });
        
        // Focus en el botón cancelar por defecto (más seguro)
        setTimeout(() => {
            cancelBtn.focus();
        }, 200);
    }
    
    // Función para mostrar notificación de procesamiento
    function showProcessingNotification() {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-500';
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-spinner fa-spin mr-3 text-red-600"></i>
                <div>
                    <p class="font-semibold">Eliminando ticket...</p>
                    <p class="text-sm">Procesando solicitud de eliminación</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Deslizar hacia dentro
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        return notification;
    }
    
    // Configurar el botón de eliminar
    const deleteButton = document.getElementById('delete-button');
    const deleteForm = document.getElementById('delete-form');
    
    if (deleteButton && deleteForm) {
        deleteButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Obtener el ID del ticket desde la URL del formulario
            const formAction = deleteForm.action;
            const ticketId = formAction.split('/').pop();
            
            showDeleteModal(
                ticketId,
                // Confirmar eliminación
                function() {
                    showProcessingNotification();
                    
                    // Enviar formulario después de un breve delay para mostrar la notificación
                    setTimeout(() => {
                        deleteForm.submit();
                    }, 500);
                },
                // Cancelar eliminación
                function() {
                    console.log('Eliminación cancelada por el usuario');
                }
            );
        });
    }
    
    // Limpiar funcionalidad antigua de confirmaciones
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