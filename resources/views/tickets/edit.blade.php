@extends('layouts.authenticated')

@section('title', 'Editar Ticket #' . $ticket->id)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tickets.index', $ticket->id) }}" 
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
                                            {{ $area->nombre }}
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
            
            // Mostrar alerta
            alert('Por favor complete todos los campos requeridos marcados con *');
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
    if (confirm('¿Está seguro de que desea marcar este ticket como resuelto? Esta acción actualizará el estado del ticket.')) {
        document.getElementById('resolveForm').submit();
    }
}

// Confirmar antes de salir si hay cambios sin guardar
let formChanged = false;
const formInputs = document.querySelectorAll('input, select, textarea');
const originalValues = {};

// Guardar valores originales
formInputs.forEach((input, index) => {
    originalValues[index] = input.value;
});

// Detectar cambios
formInputs.forEach((input, index) => {
    input.addEventListener('change', function() {
        if (this.value !== originalValues[index]) {
            formChanged = true;
        }
    });
});

// Advertir antes de salir
window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// No advertir si se envía el formulario
document.querySelector('form[action*="update"]').addEventListener('submit', function() {
    formChanged = false;
});
</script>
@endsection
