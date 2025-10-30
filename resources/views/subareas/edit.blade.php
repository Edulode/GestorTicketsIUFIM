@extends('layouts.authenticated')

@section('title', 'Editar Subárea')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Subárea</h1>
                <p class="mt-2 text-sm text-gray-700">Modifica la información de la subárea: {{ $subarea->subarea }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('subareas.show', $subarea->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Subárea
                </a>
                <a href="{{ route('subareas.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">Por favor, corrija los siguientes errores:</p>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulario -->
    <form method="POST" action="{{ route('subareas.update', $subarea->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Información de la Subárea -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-layer-group mr-2"></i>
                    Información de la Subárea
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label for="subarea" class="block text-sm font-medium text-gray-700">Nombre de la Subárea *</label>
                        <input type="text" id="subarea" name="subarea" value="{{ old('subarea', $subarea->subarea) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('subarea')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Nombre específico de la subárea o lugar.</p>
                    </div>

                    <div>
                        <label for="area_id" class="block text-sm font-medium text-gray-700">Área Padre *</label>
                        <select id="area_id" name="area_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Seleccione un área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" 
                                        {{ (old('area_id', $subarea->area_id) == $area->id) ? 'selected' : '' }}>
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Área a la que pertenece esta subárea.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-info-circle mr-2"></i>
                    Información del Sistema
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID de la Subárea</label>
                        <p class="mt-1 text-sm text-gray-900">#{{ $subarea->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Área Actual</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subarea->area->area }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subarea->created_at ? $subarea->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subarea->updated_at ? $subarea->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tickets Asociados</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $subarea->tickets->count() }} ticket(s)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Recientes -->
        @if($subarea->tickets->count() > 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Tickets Asociados
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Tickets Recientes ({{ $subarea->tickets->count() }})</h4>
                    <div class="space-y-2">
                        @foreach($subarea->tickets->take(5) as $ticket)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-ticket-alt mr-2"></i>
                                    <span class="font-medium">Ticket #{{ $ticket->id }}</span>
                                    <span class="mx-2">-</span>
                                    <span>{{ Str::limit($ticket->solicitud, 50) }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($ticket->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $ticket->status->status == 'Resuelto' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $ticket->status->status }}
                                        </span>
                                    @endif
                                    <a href="{{ route('tickets.show', $ticket->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        @if($subarea->tickets->count() > 5)
                            <p class="text-sm text-gray-500">Y {{ $subarea->tickets->count() - 5 }} ticket(s) más...</p>
                        @endif
                    </div>
                </div>
                
                @if($subarea->tickets->count() > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Nota:</strong> Esta subárea tiene {{ $subarea->tickets->count() }} ticket(s) asociados. 
                                    Cambiar el área padre podría afectar la organización de estos tickets.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Botones de Acción -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4">
                <div class="flex justify-between">
                    <button type="button" onclick="window.history.back()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script para validación en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subareaInput = document.getElementById('subarea');
    const areaSelect = document.getElementById('area_id');
    const originalAreaId = {{ $subarea->area_id }};
    
    // Validación para el campo subárea
    subareaInput.addEventListener('blur', function() {
        if (!this.value.trim()) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        }
    });
    
    subareaInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-green-500');
        }
    });

    // Validación para el select de área
    areaSelect.addEventListener('change', function() {
        if (!this.value) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        }
        
        // Mostrar advertencia si cambia de área y hay tickets asociados
        if (this.value != originalAreaId && {{ $subarea->tickets->count() }} > 0) {
            if (!document.getElementById('area-change-warning')) {
                const warning = document.createElement('div');
                warning.id = 'area-change-warning';
                warning.className = 'mt-2 bg-red-50 border border-red-200 rounded-md p-3';
                warning.innerHTML = `
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>¡Atención!</strong> Está cambiando el área padre de una subárea que tiene tickets asociados.
                            </p>
                        </div>
                    </div>
                `;
                this.parentNode.appendChild(warning);
            }
        } else {
            const warning = document.getElementById('area-change-warning');
            if (warning) {
                warning.remove();
            }
        }
    });

    // Validar formulario antes de enviar
    document.querySelector('form').addEventListener('submit', function(e) {
        let valid = true;
        
        if (!subareaInput.value.trim()) {
            subareaInput.classList.add('border-red-500');
            valid = false;
        }
        
        if (!areaSelect.value) {
            areaSelect.classList.add('border-red-500');
            valid = false;
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos.');
        }
    });
});
</script>
@endsection
