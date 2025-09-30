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
                        <p class="text-lg font-bold text-blue-700">{{ $cicloActual->ciclo }}</p>
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
                                    {{ $area->nombre }}
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
});
</script>
@endsection
