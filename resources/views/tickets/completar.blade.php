@extends('layouts.authenticated')

@section('title', 'Completar Ticket #' . $ticket->id)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('tickets.show', $ticket->id) }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Ticket
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Completar Ticket #{{ $ticket->id }}</h1>
                    <p class="mt-1 text-sm text-gray-600">Complete la información técnica para marcar el ticket como resuelto</p>
                </div>
            </div>
            
            <!-- Badge del Estado Actual -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3">
                <div class="flex items-center">
                    <i class="fas fa-clock text-yellow-600 mr-2"></i>
                    <div>
                        <p class="text-sm font-medium text-yellow-900">Estado Actual</p>
                        <p class="text-lg font-bold text-yellow-700">{{ $ticket->status->status ?? 'Pendiente' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Formulario Principal -->
        <div class="lg:col-span-2">
            <form action="{{ route('tickets.completar', $ticket->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <!-- Información de Resolución -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-tools text-blue-600 mr-2"></i>
                            Información de Resolución
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Complete los detalles de la solución implementada</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Incidencia Real -->
                        <div>
                            <label for="incidencia_real" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-1"></i>
                                Incidencia Real *
                            </label>
                            <textarea id="incidencia_real" name="incidencia_real" rows="4" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                    placeholder="Describa la incidencia real encontrada durante el diagnóstico..."
                                    required>{{ old('incidencia_real', $ticket->incidencia_real) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Describa qué problema se encontró realmente
                            </p>
                        </div>

                        <!-- Servicio Realizado -->
                        <div>
                            <label for="servicio_realizado" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-wrench mr-1"></i>
                                Servicio Realizado *
                            </label>
                            <textarea id="servicio_realizado" name="servicio_realizado" rows="4" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Describa detalladamente las acciones realizadas para solucionar el problema..."
                                      required>{{ old('servicio_realizado', $ticket->servicio_realizado) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Describa paso a paso lo que se hizo para resolver el problema
                            </p>
                        </div>

                        <!-- Observaciones -->
                        <div>
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-1"></i>
                                Observaciones Adicionales
                            </label>
                            <textarea id="observaciones" name="observaciones" rows="3" 
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                      placeholder="Comentarios adicionales, recomendaciones para el usuario, etc...">{{ old('observaciones', $ticket->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Información Técnica -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-cogs text-purple-600 mr-2"></i>
                            Información Técnica
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">Asigne el técnico responsable y categorice el servicio</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-1">
                            <!-- Técnico Responsable -->
                            <div>
                                <label for="tecnico_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-cog mr-1"></i>
                                    Técnico Responsable *
                                </label>
                                <select name="tecnico_id" id="tecnico_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                        required>
                                    <option value="">Seleccione un técnico</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{ $tecnico->id }}" 
                                                {{ old('tecnico_id', $ticket->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                            {{ $tecnico->nombre . ' ' . $tecnico->apellidoP . ' ' . $tecnico->apellidoM }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Categoría de Servicio -->
                            <div>
                                <label for="categoria_servicio_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-folder-open mr-1"></i>
                                    Categoría de Servicio
                                </label>
                                <select name="categoria_servicio_id" id="categoria_servicio_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categoriasServicio as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                                {{ old('categoria_servicio_id', $ticket->categoria_servicio_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->categoria_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tipo de Solicitud -->
                            <div>
                                <label for="tipo_solicitud_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-1"></i>
                                    Tipo de Solicitud
                                    <span id="tipos-loading" class="ml-2 text-xs text-blue-600 hidden">
                                        <i class="fas fa-spinner fa-spin mr-1"></i>Cargando...
                                    </span>
                                </label>
                                <select name="tipo_solicitud_id" id="tipo_solicitud_id" 
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Primero seleccione una categoría</option>
                                    @foreach($tipoSolicitudes as $tipo)
                                        <option value="{{ $tipo->id }}" 
                                                data-categoria="{{ $tipo->categoria_servicio_id }}"
                                                {{ old('tipo_solicitud_id', $ticket->tipo_solicitud_id) == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->tipo_solicitud }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Los tipos disponibles dependen de la categoría seleccionada
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4">
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-colors duration-200">
                                <i class="fas fa-check-circle mr-2"></i>
                                Completar y Marcar como Resuelto
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel Lateral con Información del Ticket -->
        <div class="space-y-6">
            <!-- Información del Ticket Original -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-ticket-alt mr-2 text-blue-600"></i>
                        Ticket Original
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-700 block">Solicitante</span>
                        <span class="text-sm text-gray-900">{{ $ticket->usuario->nombre . ' ' . $ticket->usuario->apellido_paterno . ' ' . $ticket->usuario->apellido_materno }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-700 block">Área</span>
                        <span class="text-sm text-gray-900">{{ $ticket->area->area }}</span>
                    </div>

                    @if($ticket->subarea)
                        <div>
                            <span class="text-sm font-medium text-gray-700 block">Lugar</span>
                            <span class="text-sm text-gray-900">{{ $ticket->subarea->subarea }}</span>
                        </div>
                    @endif

                    <div>
                        <span class="text-sm font-medium text-gray-700 block">Fecha de Creación</span>
                        <span class="text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Solicitud Original -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-comment-alt mr-2 text-green-600"></i>
                        Solicitud Original
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                        {{ $ticket->solicitud }}
                    </div>
                    
                    @if($ticket->notas)
                        <div class="mt-3">
                            <span class="text-sm font-medium text-gray-700 block mb-1">Notas Adicionales</span>
                            <div class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">
                                {{ $ticket->notas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recordatorio -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-lightbulb text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Recordatorio</h4>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li>• Complete toda la información requerida</li>
                            <li>• Sea específico en las descripciones</li>
                            <li>• El ticket se marcará automáticamente como resuelto</li>
                            <li>• Esta acción no se puede deshacer fácilmente</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para mejorar la UX del formulario -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });

    // Filtrado dinámico de tipos de solicitud por categoría de servicio
    const categoriaSelect = document.getElementById('categoria_servicio_id');
    const tipoSolicitudSelect = document.getElementById('tipo_solicitud_id');
    const loadingIndicator = document.getElementById('tipos-loading');
    
    // Almacenar todas las opciones originales
    const todasLasOpciones = Array.from(tipoSolicitudSelect.options).slice(1); // Excluir la primera opción
    
    function filtrarTiposPorCategoria() {
        const categoriaSeleccionada = categoriaSelect.value;
        
        if (!categoriaSeleccionada) {
            // Si no hay categoría seleccionada, mostrar mensaje
            tipoSolicitudSelect.innerHTML = '<option value="">Primero seleccione una categoría</option>';
            tipoSolicitudSelect.disabled = true;
            return;
        }
        
        // Mostrar indicador de carga
        loadingIndicator.classList.remove('hidden');
        tipoSolicitudSelect.disabled = true;
        
        // Hacer petición AJAX para obtener tipos de solicitud filtrados
        fetch(`{{ url('/api/tipos-solicitud') }}/${categoriaSeleccionada}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            // Limpiar opciones actuales
            tipoSolicitudSelect.innerHTML = '<option value="">Seleccione un tipo</option>';
            
            // Agregar nuevas opciones filtradas
            data.forEach(tipo => {
                const option = document.createElement('option');
                option.value = tipo.id;
                option.textContent = tipo.tipo_solicitud;
                
                // Mantener selección si coincide con el valor anterior
                const valorAnterior = '{{ old("tipo_solicitud_id", $ticket->tipo_solicitud_id) }}';
                if (valorAnterior && tipo.id == valorAnterior) {
                    option.selected = true;
                }
                
                tipoSolicitudSelect.appendChild(option);
            });
            
            // Habilitar el select
            tipoSolicitudSelect.disabled = false;
            
            // Mostrar mensaje si no hay opciones
            if (data.length === 0) {
                tipoSolicitudSelect.innerHTML = '<option value="">No hay tipos disponibles para esta categoría</option>';
            }
        })
        .catch(error => {
            console.error('Error al cargar tipos de solicitud:', error);
            tipoSolicitudSelect.innerHTML = '<option value="">Error al cargar tipos</option>';
            tipoSolicitudSelect.disabled = false;
        })
        .finally(() => {
            // Ocultar indicador de carga
            loadingIndicator.classList.add('hidden');
        });
    }
    
    // Evento para filtrar cuando cambie la categoría
    categoriaSelect.addEventListener('change', filtrarTiposPorCategoria);
    
    // Inicializar al cargar la página si hay una categoría preseleccionada
    if (categoriaSelect.value) {
        setTimeout(filtrarTiposPorCategoria, 100);
    } else {
        tipoSolicitudSelect.disabled = true;
    }

    // Character counter para los campos principales
    const incidenciaTextarea = document.getElementById('incidencia_real');
    const servicioTextarea = document.getElementById('servicio_realizado');
    
    function addCharacterCounter(textarea, maxLength) {
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-sm text-gray-500 mt-1 text-right';
        textarea.parentNode.appendChild(counterDiv);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counterDiv.textContent = `${textarea.value.length}/${maxLength} caracteres`;
            
            if (remaining < 50) {
                counterDiv.classList.add('text-red-500');
                counterDiv.classList.remove('text-gray-500');
            } else {
                counterDiv.classList.remove('text-red-500');
                counterDiv.classList.add('text-gray-500');
            }
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    }
    
    if (incidenciaTextarea) addCharacterCounter(incidenciaTextarea, 1000);
    if (servicioTextarea) addCharacterCounter(servicioTextarea, 1000);

    // Validación del formulario antes del submit
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('[required]');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
                field.classList.remove('border-gray-300');
            } else {
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
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
            
            // Mostrar mensaje de error
            alert('Por favor complete todos los campos requeridos marcados con asterisco (*)');
        } else {
            // Confirmación final
            if (!confirm('¿Está seguro de completar este ticket? Se marcará como resuelto y no se podrá modificar fácilmente.')) {
                e.preventDefault();
            }
        }
    });

    // Limpiar estilos de error al escribir en campos
    requiredFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            }
        });
    });
});
</script>
@endsection