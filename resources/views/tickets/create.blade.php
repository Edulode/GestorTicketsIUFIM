@extends('layouts.app')

@section('title', 'Soporte Tecnico')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    

    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h1 class="text-3xl font-bold text-gray-900">Levantar reporte</h1>
                    <p class="mt-1 text-sm text-gray-600">Complete el formulario para reportar un incidente o solicitar soporte técnico</p>
                </div>
            </div>
            
            <!-- Información del Ciclo Actual -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                    <div>
                        <p class="text-sm font-medium text-blue-900">Ciclo Actual</p>
                        @if($cicloActual)
                            <p class="text-lg font-bold text-blue-700">{{ $cicloActual->ciclo }}</p>
                        @else
                            <p class="text-lg font-bold text-gray-500">No hay ciclo definido</p>
                        @endif
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

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">¡Ticket creado exitosamente!</h3>
                    <p class="mt-1 text-sm text-green-700">{{ session('success') }}</p>
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
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <p class="mt-1 text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Campos ocultos con valores por defecto -->
        @if($cicloActual)
            <input type="hidden" name="ciclo_id" value="{{ $cicloActual->id }}">
        @endif
        <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
        <input type="hidden" name="status_id" value="1">
        <input type="hidden" name="tipo_id" value="1">
        <input type="hidden" name="asunto_id" value="1">
        
        <!-- Información del Usuario -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Información del Usuario
                </h3>
                <p class="mt-1 text-sm text-gray-600">Seleccione el usuario que reporta el incidente</p>
                
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Usuario -->
                    <div class="col-span-2 sm:col-span-1">
                        <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-circle mr-1"></i>
                            Usuario Solicitante *
                        </label>
                        <select name="usuario_id" id="usuario_id" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                required>
                            <option value="">Seleccione un usuario</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nombre . " " . $usuario->apellido_paterno . " " . $usuario->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Área -->
                    <div class="col-span-2 sm:col-span-1">
                        <label for="area_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-1"></i>
                            Área *
                            <span id="area-auto-label" class="ml-2 text-xs text-green-600 hidden">
                                <i class="fas fa-magic mr-1"></i>Auto-completado
                            </span>
                        </label>
                        <select name="area_id" id="area_id" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200" 
                                required>
                            <option value="">Seleccione un área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Se establecerá automáticamente, pero puede modificarse
                        </p>
                    </div>

                    <!-- Subárea/Lugar de Incidencia -->
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
                                <option value="{{ $subarea->id }}" {{ old('subarea_id') == $subarea->id ? 'selected' : '' }}>
                                    {{ $subarea->subarea }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Descripción del Problema -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-edit text-purple-600 mr-2"></i>
                    Descripción Detallada
                </h3>
                <p class="mt-1 text-sm text-gray-600">Proporcione toda la información relevante sobre el incidente</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Solicitud -->
                <div>
                    <label for="solicitud" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment-alt mr-1"></i>
                        Descripción del Problema *
                    </label>
                    <div class="mt-1">
                        <textarea id="solicitud" name="solicitud" rows="5" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                placeholder="Describa detalladamente el problema o solicitud, mensajes de error exactos, y cualquier información relevante..."
                                required>{{ old('solicitud') }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Proporcione la mayor cantidad de detalles posible para un diagnóstico más rápido
                    </p>
                </div>

                <!-- Notas Adicionales -->
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sticky-note mr-1"></i>
                        Notas Adicionales (Opcional)
                    </label>
                    <div class="mt-1">
                        <textarea id="notas" name="notas" rows="3" 
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" 
                                  placeholder="Información adicional, contexto, o cualquier detalle que pueda ser útil...">{{ old('notas') }}</textarea>
                    </div>
                </div>

               
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Crear Ticket
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
/* Menús desplegables compactos limitados a área pequeña */
.select-container {
    position: relative;
}

/* Indicador de búsqueda */
.search-indicator {
    position: absolute;
    top: -25px;
    left: 0;
    background-color: #1f2937;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 1001;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.search-indicator.show {
    opacity: 1;
}

select {
    transition: all 0.2s ease-in-out;
}

/* Estado normal del select */
select:not([data-expanded="true"]) {
    height: 42px;
    overflow: hidden;
}

/* Estado expandido - área pequeña y compacta */
select[data-expanded="true"] {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1000 !important;
    background-color: white !important;
    border: 2px solid #3b82f6 !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1) !important;
    max-height: 250px !important;
    height: auto !important;
    overflow-y: auto !important;
    size: 8 !important;
    padding: 4px !important;
}

/* Estilo mejorado para las opciones */
select option {
    padding: 8px 12px;
    background-color: white;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    line-height: 1.4;
}

select option:hover {
    background-color: #f8fafc !important;
    color: #1f2937 !important;
}

select option:checked,
select option:selected {
    background-color: #3b82f6 !important;
    color: white !important;
    font-weight: 500;
}

/* Scroll bar personalizada */
select::-webkit-scrollbar {
    width: 6px;
}

select::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

select::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

select::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animación suave para la expansión */
select.expanding {
    animation: expandSelect 0.2s ease-out;
}

select.collapsing {
    animation: collapseSelect 0.2s ease-in;
}

@keyframes expandSelect {
    from {
        max-height: 42px;
        box-shadow: none;
    }
    to {
        max-height: 250px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
}

@keyframes collapseSelect {
    from {
        max-height: 250px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
    to {
        max-height: 42px;
        box-shadow: none;
    }
}
</style>

<!-- Script para mejorar la UX del formulario -->
<script>
// Datos de usuarios con sus áreas
const usuariosData = {
    @foreach($usuarios as $usuario)
        {{ $usuario->id }}: {
            id: {{ $usuario->id }},
            nombre: "{{ $usuario->nombre }}",
            area_id: {{ $usuario->area_id ?? 'null' }},
            area_nombre: "{{ $usuario->area ? $usuario->area->nombre : '' }}"
        },
    @endforeach
};

document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad para autocompletar área cuando se selecciona usuario
    const usuarioSelect = document.getElementById('usuario_id');
    const areaSelect = document.getElementById('area_id');
    const areaAutoLabel = document.getElementById('area-auto-label');
    
    usuarioSelect.addEventListener('change', function() {
        const usuarioId = this.value;
        
        if (usuarioId && usuariosData[usuarioId]) {
            const usuario = usuariosData[usuarioId];
            
            if (usuario.area_id) {
                // Seleccionar automáticamente el área del usuario
                areaSelect.value = usuario.area_id;
                
                // Mostrar el indicador de auto-completado
                areaAutoLabel.classList.remove('hidden');
                
                // Mostrar un efecto visual para indicar que se autocompletó
                areaSelect.classList.add('bg-green-50', 'border-green-300');
                setTimeout(() => {
                    areaSelect.classList.remove('bg-green-50', 'border-green-300');
                }, 2000);
                
                // Mostrar notificación temporal
                showNotification(`Área establecida automáticamente: ${usuario.area_nombre}`, 'success');
            } else {
                // Ocultar el indicador si el usuario no tiene área
                areaAutoLabel.classList.add('hidden');
            }
        } else {
            // Limpiar selección de área si no hay usuario seleccionado
            areaSelect.value = '';
            areaAutoLabel.classList.add('hidden');
        }
    });

    // Detectar cambios manuales en el área para ocultar el indicador de auto-completado
    areaSelect.addEventListener('change', function() {
        if (this.value && !usuarioSelect.value) {
            // Si se selecciona un área manualmente sin usuario, no mostrar auto-completado
            areaAutoLabel.classList.add('hidden');
        } else if (this.value && usuarioSelect.value) {
            const usuario = usuariosData[usuarioSelect.value];
            if (usuario && this.value != usuario.area_id) {
                // Si se cambia manualmente a un área diferente, ocultar el indicador
                areaAutoLabel.classList.add('hidden');
            }
        }
    });

    // Función para mostrar notificaciones temporales
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-md shadow-lg transition-all duration-300 transform translate-x-full`;
        
        if (type === 'success') {
            notification.classList.add('bg-green-100', 'border', 'border-green-300', 'text-green-800');
        } else {
            notification.classList.add('bg-blue-100', 'border', 'border-blue-300', 'text-blue-800');
        }
        
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
                <span class="text-sm">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Mostrar la notificación
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Ocultar la notificación después de 3 segundos
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Mejorar la selección de prioridad
    const priorityRadios = document.querySelectorAll('input[name="prioridad"]');
    priorityRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remover la clase seleccionada de todos los labels
            priorityRadios.forEach(r => {
                r.closest('label').classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                r.closest('label').classList.add('border-gray-200');
            });
            
            // Agregar la clase seleccionada al label actual
            if (this.checked) {
                this.closest('label').classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                this.closest('label').classList.remove('border-gray-200');
            }
        });
    });
    
    // Inicializar la selección por defecto
    const checkedRadio = document.querySelector('input[name="prioridad"]:checked');
    if (checkedRadio) {
        checkedRadio.closest('label').classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
        checkedRadio.closest('label').classList.remove('border-gray-200');
    }
    
    // Validación del formulario
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
        }
    });
    
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
    
    // Character counter para la descripción principal
    const solicitudTextarea = document.getElementById('solicitud');
    if (solicitudTextarea) {
        const maxLength = 1000;
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-sm text-gray-500 mt-1 text-right';
        solicitudTextarea.parentNode.appendChild(counterDiv);
        
        function updateCounter() {
            const remaining = maxLength - solicitudTextarea.value.length;
            counterDiv.textContent = `${solicitudTextarea.value.length}/${maxLength} caracteres`;
            
            if (remaining < 50) {
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

    // Función para manejar menús desplegables compactos
    function setupCompactSelects() {
        const selects = document.querySelectorAll('select');
        
        selects.forEach(select => {
            // Envolver cada select en un contenedor si no lo tiene
            if (!select.parentElement.classList.contains('select-container')) {
                const container = document.createElement('div');
                container.className = 'select-container';
                select.parentElement.insertBefore(container, select);
                container.appendChild(select);
            }
            
            // Crear indicador de búsqueda
            const searchIndicator = document.createElement('div');
            searchIndicator.className = 'search-indicator';
            searchIndicator.textContent = 'Buscando...';
            select.parentElement.appendChild(searchIndicator);
            
            const optionCount = select.options.length;
            
            // Aplicar a selects con más de 3 opciones o específicamente al select de lugar de incidencia
            if (optionCount > 3 || select.id === 'subarea_id') {
                let isExpanded = false;
                let searchString = '';
                let searchTimeout;
                
                // Al hacer clic, expandir de forma compacta
                select.addEventListener('mousedown', function(e) {
                    if (!isExpanded) {
                        e.preventDefault();
                        expandSelect(this);
                        isExpanded = true;
                    }
                });
                
                // Manejar la búsqueda por teclado sin seleccionar automáticamente
                select.addEventListener('keydown', function(e) {
                    // Si es una letra, número o espacio, agregar a la búsqueda
                    if (e.key.length === 1 && /[a-zA-Z0-9\s]/.test(e.key)) {
                        e.preventDefault(); // Prevenir selección automática
                        
                        searchString += e.key.toLowerCase();
                        
                        // Limpiar timeout anterior
                        clearTimeout(searchTimeout);
                        
                        // Buscar coincidencias
                        highlightMatch(this, searchString);
                        
                        // Mostrar indicador de búsqueda
                        showSearchIndicator(this, searchString);
                        
                        // Limpiar búsqueda después de 1 segundo
                        searchTimeout = setTimeout(() => {
                            searchString = '';
                            hideSearchIndicator(this);
                        }, 1000);
                        
                        return false;
                    }
                    
                    // Permitir navegación con flechas
                    if (['ArrowUp', 'ArrowDown', 'Home', 'End'].includes(e.key)) {
                        // Comportamiento normal de navegación
                        return true;
                    }
                    
                    // Enter para seleccionar
                    if (e.key === 'Enter') {
                        this.dispatchEvent(new Event('change'));
                        collapseSelect(this);
                        isExpanded = false;
                        searchString = '';
                        hideSearchIndicator(this);
                    }
                    
                    // Escape para cerrar
                    if (e.key === 'Escape') {
                        collapseSelect(this);
                        isExpanded = false;
                        searchString = '';
                        hideSearchIndicator(this);
                        this.blur();
                    }
                    
                    // Backspace para borrar búsqueda
                    if (e.key === 'Backspace') {
                        e.preventDefault();
                        searchString = searchString.slice(0, -1);
                        if (searchString) {
                            highlightMatch(this, searchString);
                        }
                    }
                });
                
                // Al hacer clic en una opción, cerrar
                select.addEventListener('change', function() {
                    collapseSelect(this);
                    isExpanded = false;
                    searchString = '';
                    hideSearchIndicator(this);
                });
                
                // Cerrar al perder el foco
                select.addEventListener('blur', function() {
                    setTimeout(() => {
                        collapseSelect(this);
                        isExpanded = false;
                        searchString = '';
                        hideSearchIndicator(this);
                    }, 150);
                });
            }
        });
        
        // Función para mostrar indicador de búsqueda
        function showSearchIndicator(select, searchStr) {
            const indicator = select.parentElement.querySelector('.search-indicator');
            if (indicator) {
                indicator.textContent = `Buscando: "${searchStr}"`;
                indicator.classList.add('show');
            }
        }
        
        // Función para ocultar indicador de búsqueda
        function hideSearchIndicator(select) {
            const indicator = select.parentElement.querySelector('.search-indicator');
            if (indicator) {
                indicator.classList.remove('show');
            }
        }
        
        // Función para resaltar coincidencias sin seleccionar
        function highlightMatch(select, searchStr) {
            const options = Array.from(select.options);
            let foundIndex = -1;
            
            // Buscar la primera coincidencia desde el inicio del texto
            for (let i = 0; i < options.length; i++) {
                const optionText = options[i].text.toLowerCase();
                if (optionText.startsWith(searchStr)) {
                    foundIndex = i;
                    break;
                }
            }
            
            // Si encuentra coincidencia, hacer scroll para mostrarla pero no seleccionarla
            if (foundIndex !== -1) {
                const option = options[foundIndex];
                option.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                
                // Resaltar visualmente sin seleccionar
                options.forEach(opt => opt.style.backgroundColor = '');
                option.style.backgroundColor = '#e0f2fe';
                
                // Limpiar resaltado después de un momento
                setTimeout(() => {
                    option.style.backgroundColor = '';
                }, 800);
            }
        }
        
        function expandSelect(select) {
            select.setAttribute('data-expanded', 'true');
            select.classList.add('expanding');
            select.setAttribute('size', '8');
            select.focus();
            
            setTimeout(() => {
                select.classList.remove('expanding');
            }, 200);
        }
        
        function collapseSelect(select) {
            select.classList.add('collapsing');
            
            setTimeout(() => {
                select.removeAttribute('data-expanded');
                select.removeAttribute('size');
                select.classList.remove('collapsing');
            }, 200);
        }
        
        // Cerrar cualquier select abierto al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('select')) {
                selects.forEach(select => {
                    if (select.getAttribute('data-expanded') === 'true') {
                        collapseSelect(select);
                    }
                });
            }
        });
    }
    
    // Inicializar selects compactos
    setupCompactSelects();
});
</script>
@endsection
