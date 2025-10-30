@extends('layouts.authenticated')

@section('title', 'Editar Ticket #' . $ticket->id)

@section('content')
<!-- Estilos personalizados para mejorar la UX -->
<style>
    .modal-backdrop {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    
    .unsaved-indicator {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .form-field-focus {
        transform: scale(1.02);
        transition: transform 0.2s ease;
    }
    
    .save-button-loading {
        background: linear-gradient(45deg, #3b82f6, #1d4ed8);
        background-size: 200% 200%;
        animation: gradientShift 2s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .modal-enter {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .notification-slide {
        animation: slideInRight 0.5s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .field-error {
        animation: shake 0.6s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tickets.show', $ticket->id) }}" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Ticket #{{ $ticket->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Modifique la información del ticket según sea necesario
                    </p>
                </div>
            </div>
            
            <!-- Estado actual -->
            <div class="flex items-center">
                <span class="text-sm font-medium text-gray-700 mr-2">Estado Actual:</span>
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
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Por favor corrija los siguientes errores:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

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

    <!-- Formulario de Edición -->
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna Principal (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Información Básica del Ticket -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-ticket-alt text-blue-600 mr-2"></i>
                            Información del Ticket
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Datos fundamentales del ticket de soporte</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Ciclo -->
                            <div>
                                <label for="ciclo_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Ciclo *
                                </label>
                                <select name="ciclo_id" id="ciclo_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un ciclo</option>
                                    @foreach($ciclos as $ciclo)
                                        <option value="{{ $ciclo->id }}" {{ $ticket->ciclo_id == $ciclo->id ? 'selected' : '' }}>
                                            {{ $ciclo->ciclo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo -->
                            <div>
                                <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-1"></i>
                                    Tipo *
                                </label>
                                <select name="tipo_id" id="tipo_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ $ticket->tipo_id == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha del Incidente -->
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Fecha del Incidente *
                                </label>
                                <input type="date" name="fecha" id="fecha" 
                                       value="{{ $ticket->fecha ? \Carbon\Carbon::parse($ticket->fecha)->format('Y-m-d') : '' }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                       required>
                            </div>

                            <!-- Fecha de Atención -->
                            <div>
                                <label for="fecha_atencion" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-1"></i>
                                    Fecha de Atención
                                </label>
                                <input type="datetime-local" name="fecha_atencion" id="fecha_atencion" 
                                       value="{{ $ticket->fecha_atencion ? \Carbon\Carbon::parse($ticket->fecha_atencion)->format('Y-m-d\TH:i') : '' }}"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Usuario y Ubicación -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-user text-green-600 mr-2"></i>
                            Usuario y Ubicación
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Información del solicitante y ubicación del incidente</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Usuario -->
                            <div>
                                <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-circle mr-1"></i>
                                    Usuario Solicitante *
                                </label>
                                <select name="usuario_id" id="usuario_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}" {{ $ticket->usuario_id == $usuario->id ? 'selected' : '' }}>
                                            {{ $usuario->nombre . " " . $usuario->apellido_paterno . " " . $usuario->apellido_materno }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Área -->
                            <div>
                                <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-building mr-1"></i>
                                    Área *
                                </label>
                                <select name="area_id" id="area_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ $ticket->area_id == $area->id ? 'selected' : '' }}>
                                            {{ $area->area }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subárea -->
                            <div class="col-span-2">
                                <label for="subarea_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Lugar de Incidencia *
                                </label>
                                <select name="subarea_id" id="subarea_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione una ubicación</option>
                                    @foreach($subareas as $subarea)
                                        <option value="{{ $subarea->id }}" {{ $ticket->subarea_id == $subarea->id ? 'selected' : '' }}>
                                            {{ $subarea->subarea }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categorización del Ticket -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-folder-open text-purple-600 mr-2"></i>
                            Categorización del Ticket
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Clasificación y categoría del ticket</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Asunto -->
                            <div>
                                <label for="asunto_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-subject mr-1"></i>
                                    Asunto *
                                </label>
                                <select name="asunto_id" id="asunto_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un asunto</option>
                                    @foreach($asuntos as $asunto)
                                        <option value="{{ $asunto->id }}" {{ $ticket->asunto_id == $asunto->id ? 'selected' : '' }}>
                                            {{ $asunto->asunto }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo de Solicitud -->
                            <div>
                                <label for="tipo_solicitud_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clipboard-list mr-1"></i>
                                    Tipo de Solicitud *
                                </label>
                                <select name="tipo_solicitud_id" id="tipo_solicitud_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un tipo de solicitud</option>
                                    @foreach($tipoSolicitudes as $tipoSolicitud)
                                        <option value="{{ $tipoSolicitud->id }}" {{ $ticket->tipo_solicitud_id == $tipoSolicitud->id ? 'selected' : '' }}>
                                            {{ $tipoSolicitud->tipo_solicitud }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categoría de Servicio -->
                            <div class="col-span-2">
                                <label for="categoria_servicio_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-layer-group mr-1"></i>
                                    Categoría de Servicio
                                </label>
                                <select name="categoria_servicio_id" id="categoria_servicio_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categoriasServicio as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $ticket->categoria_servicio_id == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->categoria_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción y Detalles -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-edit text-orange-600 mr-2"></i>
                            Descripción y Detalles
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Información detallada sobre el problema y su resolución</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Solicitud Original -->
                        <div>
                            <label for="solicitud" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-comment-alt mr-1"></i>
                                Descripción del Problema *
                            </label>
                            <textarea id="solicitud" name="solicitud" rows="4" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Describa detalladamente el problema o solicitud..."
                                      required>{{ $ticket->solicitud }}</textarea>
                        </div>

                        <!-- Incidencia Real -->
                        <div>
                            <label for="incidencia_real" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Incidencia Real
                            </label>
                            <textarea id="incidencia_real" name="incidencia_real" rows="3" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Describa la incidencia real encontrada durante la revisión...">{{ $ticket->incidencia_real }}</textarea>
                        </div>

                        <!-- Servicio Realizado -->
                        <div>
                            <label for="servicio_realizado" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tools mr-1"></i>
                                Servicio Realizado
                            </label>
                            <textarea id="servicio_realizado" name="servicio_realizado" rows="3" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Describa el servicio que se realizó para resolver el problema...">{{ $ticket->servicio_realizado }}</textarea>
                        </div>

                        <!-- Notas -->
                        <div>
                            <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Notas Adicionales
                            </label>
                            <textarea id="notas" name="notas" rows="3" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Información adicional, contexto, o cualquier detalle útil...">{{ $ticket->notas }}</textarea>
                        </div>

                        <!-- Observaciones -->
                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-eye mr-1"></i>
                                Observaciones
                            </label>
                            <textarea id="observaciones" name="observaciones" rows="3" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Observaciones generales sobre el ticket...">{{ $ticket->observaciones }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral (1/3) -->
            <div class="space-y-8">
                
                <!-- Estado y Asignación -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-tasks text-indigo-600 mr-2"></i>
                            Estado y Asignación
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Control del estado y asignación del ticket</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Estado -->
                        <div>
                            <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-flag mr-1"></i>
                                Estado del Ticket
                            </label>
                            <select name="status_id" id="status_id" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Sin estado</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Técnico Asignado -->
                        <div>
                            <label for="tecnico_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-cog mr-1"></i>
                                Técnico Asignado
                            </label>
                            <select name="tecnico_id" id="tecnico_id" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ $ticket->tecnico_id == $tecnico->id ? 'selected' : '' }}>
                                        {{ $tecnico->nombre . " " . $tecnico->apellidoP . " " . $tecnico->apellidoM }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Información del Ticket -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Información del Ticket
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">ID del Ticket:</span>
                            <span class="text-sm text-gray-900">#{{ $ticket->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Creado:</span>
                            <span class="text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Última actualización:</span>
                            <span class="text-sm text-gray-900">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-cogs text-gray-600 mr-2"></i>
                            Acciones
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <!-- Botón Guardar -->
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Cambios
                        </button>

                        <!-- Botón Cancelar -->
                        <a href="{{ route('tickets.show', $ticket->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                        

                        <!-- Marcar como Resuelto (si no está resuelto) -->
                        @if($ticket->status && $ticket->status->status !== 'Resuelto')
                            <button type="button" 
                                    onclick="markAsResolved()"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-colors duration-200">
                                <i class="fas fa-check mr-2"></i>
                                Marcar como Resuelto
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Formulario oculto para marcar como resuelto -->
@if($ticket->status && $ticket->status->status !== 'Resuelto')
    <form id="resolveForm" action="{{ route('tickets.markAsResolved', $ticket->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>
@endif

<!-- JavaScript para funcionalidades del formulario -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        // Set initial height
        autoResize(textarea);
        
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });
    
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
    
    // Validación del formulario
    const form = document.querySelector('form[action*="update"]');
    const requiredFields = form.querySelectorAll('[required]');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500', 'ring-red-500');
                field.classList.remove('border-gray-300');
                
                // Agregar mensaje de error si no existe
                let errorMsg = field.parentNode.querySelector('.error-message');
                if (!errorMsg) {
                    errorMsg = document.createElement('p');
                    errorMsg.className = 'error-message text-sm text-red-600 mt-1';
                    errorMsg.textContent = 'Este campo es requerido';
                    field.parentNode.appendChild(errorMsg);
                }
            } else {
                field.classList.remove('border-red-500', 'ring-red-500');
                field.classList.add('border-gray-300');
                
                // Remover mensaje de error si existe
                let errorMsg = field.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Scroll al primer campo con error
            const firstError = form.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            
            // Mostrar modal personalizado en lugar de alert
            showValidationModal();
        }
    });
    
    // Limpiar errores cuando el usuario empiece a escribir
    requiredFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500', 'ring-red-500');
                this.classList.add('border-gray-300');
                
                let errorMsg = this.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
            }
        });
    });
    
    // Character counter para solicitud
    const solicitudTextarea = document.getElementById('solicitud');
    if (solicitudTextarea) {
        const maxLength = 2000;
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-sm text-gray-500 mt-1 text-right';
        solicitudTextarea.parentNode.appendChild(counterDiv);
        
        function updateCounter() {
            const remaining = maxLength - solicitudTextarea.value.length;
            counterDiv.textContent = `${solicitudTextarea.value.length}/${maxLength} caracteres`;
            
            if (remaining < 100) {
                counterDiv.classList.add('text-red-500');
                counterDiv.classList.remove('text-gray-500');
            } else {
                counterDiv.classList.remove('text-red-500');
                counterDiv.classList.add('text-gray-500');
            }
        }
        
        solicitudTextarea.addEventListener('input', updateCounter);
        updateCounter();
    }
});

// Función para marcar como resuelto
function markAsResolved() {
    showCustomModal(
        'Confirmar Resolución',
        '¿Está seguro de que desea marcar este ticket como resuelto?',
        'Esta acción actualizará el estado del ticket y se notificará al usuario solicitante.',
        'Marcar como Resuelto',
        'Cancelar',
        function() {
            document.getElementById('resolveForm').submit();
        }
    );
}

// Sistema de gestión de cambios más profesional
let formChanged = false;
let formSubmitting = false;
const formInputs = document.querySelectorAll('input, select, textarea');
const originalValues = {};

// Guardar valores originales
formInputs.forEach((input, index) => {
    originalValues[index] = input.value;
});

// Detectar cambios
formInputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value !== originalValues[index]) {
            formChanged = true;
            showUnsavedChangesIndicator();
        } else {
            checkAllValuesForChanges();
        }
    });
    
    input.addEventListener('change', function() {
        if (this.value !== originalValues[index]) {
            formChanged = true;
            showUnsavedChangesIndicator();
        } else {
            checkAllValuesForChanges();
        }
    });
});

// Verificar si realmente hay cambios
function checkAllValuesForChanges() {
    let hasChanges = false;
    formInputs.forEach((input, index) => {
        if (input.value !== originalValues[index]) {
            hasChanges = true;
        }
    });
    
    if (!hasChanges) {
        formChanged = false;
        hideUnsavedChangesIndicator();
    }
}

// Indicador visual de cambios no guardados mejorado
function showUnsavedChangesIndicator() {
    let indicator = document.getElementById('unsaved-changes-indicator');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.id = 'unsaved-changes-indicator';
        indicator.className = 'unsaved-indicator fixed top-4 right-4 bg-gradient-to-r from-yellow-100 to-orange-100 border-l-4 border-yellow-500 text-yellow-800 px-6 py-4 rounded-lg shadow-xl z-50 transform transition-all duration-500 translate-x-full';
        indicator.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-lg animate-pulse"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold">Cambios sin guardar</p>
                    <p class="text-xs mt-1 opacity-90">Los cambios se perderán si sale sin guardar</p>
                </div>
                <div class="ml-4">
                </div>
            </div>
        `;
        document.body.appendChild(indicator);
        
        // Animación de entrada mejorada
        setTimeout(() => {
            indicator.classList.add('notification-slide');
            indicator.classList.remove('translate-x-full');
        }, 100);
    }
}

function hideUnsavedChangesIndicator() {
    const indicator = document.getElementById('unsaved-changes-indicator');
    if (indicator) {
        indicator.classList.add('translate-x-full');
        setTimeout(() => {
            indicator.remove();
        }, 300);
    }
}

// Interceptar intentos de navegación
function handleNavigation(e) {
    if (formChanged && !formSubmitting) {
        e.preventDefault();
        e.stopPropagation();
        
        const targetUrl = e.target.href || e.currentTarget.href;
        
        showCustomModal(
            'Cambios sin Guardar',
            '¿Desea salir sin guardar los cambios?',
            'Los cambios realizados en el ticket se perderán si continúa sin guardar.',
            'Salir sin Guardar',
            'Continuar Editando',
            function() {
                formChanged = false;
                window.location.href = targetUrl;
            }
        );
        
        return false;
    }
}

// Aplicar interceptor a enlaces de navegación
document.querySelectorAll('a[href]').forEach(link => {
    // Solo interceptar enlaces que no sean para acciones del formulario
    if (!link.href.includes('#') && !link.href.includes('javascript:')) {
        link.addEventListener('click', handleNavigation);
    }
});

// Marcar cuando el formulario se está enviando
document.querySelector('form[action*="update"]').addEventListener('submit', function() {
    formSubmitting = true;
    formChanged = false;
    hideUnsavedChangesIndicator();
});

// Modal personalizado más profesional y elegante
function showCustomModal(title, message, description, confirmText, cancelText, onConfirm, onCancel) {
    // Crear backdrop con blur
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full z-50 transition-all duration-400 opacity-0';
    
    // Crear modal con animación mejorada
    const modal = document.createElement('div');
    modal.className = 'modal-enter relative top-20 mx-auto p-6 border-0 w-96 shadow-2xl rounded-xl bg-white transform transition-all duration-400 scale-95';
    
    modal.innerHTML = `
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-yellow-100 to-orange-100 mb-6 shadow-inner">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
            </div>
            <h3 class="text-xl leading-6 font-bold text-gray-900 mb-3">${title}</h3>
            <div class="mt-3 px-4 py-2">
                <p class="text-base text-gray-700 mb-3 font-medium leading-relaxed">${message}</p>
                <p class="text-sm text-gray-500 leading-relaxed">${description}</p>
            </div>
            <div class="flex justify-center space-x-4 mt-8">
                <button id="modal-cancel" type="button" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-3 focus:ring-gray-300 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-times mr-2"></i>${cancelText}
                </button>
                <button id="modal-confirm" type="button" 
                        class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white text-sm font-semibold rounded-lg hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-3 focus:ring-yellow-300 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-exclamation-triangle mr-2"></i>${confirmText}
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
        }, 400);
    }
    
    confirmBtn.addEventListener('click', function() {
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
    
    // Focus en el botón cancelar por defecto con delay
    setTimeout(() => {
        cancelBtn.focus();
    }, 200);
}

// Función de guardado rápido
function quickSave() {
    const form = document.querySelector('form[action*="update"]');
    const requiredFields = form.querySelectorAll('[required]');
    
    // Verificar campos requeridos
    let isValid = true;
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
        }
    });
    
    if (isValid) {
        // Mostrar indicador de guardado
        showSavingIndicator();
        form.submit();
    } else {
        showValidationModal();
    }
}

// Indicador de guardado en proceso
function showSavingIndicator() {
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-6 py-4 rounded-lg shadow-lg z-50 notification-slide';
    indicator.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-spinner fa-spin mr-3 text-blue-600"></i>
            <div>
                <p class="font-semibold">Guardando cambios...</p>
                <p class="text-sm">Por favor espere un momento</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(indicator);
    
    // Ocultar el indicador de cambios sin guardar
    hideUnsavedChangesIndicator();
}

// Modal para errores de validación
function showValidationModal() {
    showCustomModal(
        'Campos Requeridos',
        'Por favor complete todos los campos obligatorios',
        'Los campos marcados con asterisco (*) son requeridos para poder guardar el ticket.',
        'Entendido',
        '',
        function() {
            // Focus en el primer campo con error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    );
}

// Función para mostrar confirmación de guardado exitoso
function showSuccessMessage() {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-x-full';
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            <div>
                <p class="font-medium">¡Cambios guardados exitosamente!</p>
                <p class="text-sm">El ticket ha sido actualizado correctamente.</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animación de entrada
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-ocultar después de 4 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 500);
    }, 4000);
}

// Mejorar la experiencia del botón de guardar
const saveButton = document.querySelector('button[type="submit"]');
if (saveButton) {
    const originalText = saveButton.innerHTML;
    
    saveButton.addEventListener('click', function() {
        // Cambiar texto del botón mientras se procesa
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
        this.disabled = true;
        
        // Restaurar el botón si hay errores de validación
        setTimeout(() => {
            if (document.querySelector('.border-red-500')) {
                this.innerHTML = originalText;
                this.disabled = false;
            }
        }, 100);
    });
}

// Interceptar navegación con modal personalizado
function interceptNavigation() {
    // Interceptar todos los enlaces
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && formChanged && !formSubmitting) {
            e.preventDefault();
            
            showCustomModal(
                'Cambios Sin Guardar',
                '¿Desea guardar los cambios antes de continuar?',
                'Los cambios realizados en este ticket se perderán si no los guarda.',
                'Guardar y Continuar',
                'Descartar Cambios',
                function() {
                    // Guardar primero, luego navegar
                    quickSave();
                    setTimeout(() => {
                        window.location.href = link.href;
                    }, 1000);
                },
                function() {
                    // Navegar sin guardar
                    formChanged = false;
                    window.location.href = link.href;
                }
            );
        }
    });
    
    // Interceptar el botón atrás del navegador
    window.addEventListener('popstate', function(e) {
        if (formChanged && !formSubmitting) {
            history.pushState(null, '', window.location.href);
            
            showCustomModal(
                'Cambios Sin Guardar',
                '¿Desea guardar los cambios antes de salir?',
                'Los cambios realizados en este ticket se perderán si no los guarda.',
                'Guardar Cambios',
                'Salir Sin Guardar',
                function() {
                    quickSave();
                },
                function() {
                    formChanged = false;
                    history.back();
                }
            );
        }
    });
}

// Inicializar interceptor de navegación
interceptNavigation();
</script>
@endsection
