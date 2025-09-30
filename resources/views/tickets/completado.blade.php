@extends('layouts.authenticated')

@section('title', 'Completar Ticket')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Completar Ticket #{{ $ticket->id }}</h1>
                <p class="mt-2 text-sm text-gray-700">Complete la información final del ticket antes de marcarlo como resuelto</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tickets.show', $ticket->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Ticket
                </a>
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

    <!-- Información del Ticket Actual -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-info-circle mr-2"></i>
                Información del Ticket
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Usuario</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido_paterno }} {{ $ticket->usuario->apellido_materno }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Área</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $ticket->area->area }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="md:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-medium text-gray-700">Solicitud Original</label>
                    <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $ticket->solicitud }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Completado -->
    <form method="POST" action="{{ route('tickets.complete', $ticket->id) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- Información Técnica -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-tools mr-2"></i>
                    Información Técnica
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tecnico_id" class="block text-sm font-medium text-gray-700">Técnico Asignado *</label>
                        <select id="tecnico_id" name="tecnico_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar técnico</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ old('tecnico_id', $ticket->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre . ' ' . $tecnico->apellidoP . ' ' . $tecnico->apellidoM }}
                                </option>
                            @endforeach
                        </select>
                        @error('tecnico_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="categoria_servicio_id" class="block text-sm font-medium text-gray-700">Categoría de Servicio *</label>
                        <select id="categoria_servicio_id" name="categoria_servicio_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar categoría</option>
                            @foreach($categoriasServicio as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_servicio_id', $ticket->categoriaServicio) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->categoria_servicio }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_servicio_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="asunto_id" class="block text-sm font-medium text-gray-700">Asunto *</label>
                        <select id="asunto_id" name="asunto_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar asunto</option>
                            @foreach($asuntos as $asunto)
                                <option value="{{ $asunto->id }}" {{ old('asunto_id', $ticket->asunto_id) == $asunto->id ? 'selected' : '' }}>
                                    {{ $asunto->asunto }}
                                </option>
                            @endforeach
                        </select>
                        @error('asunto_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipo_solicitud_id" class="block text-sm font-medium text-gray-700">Tipo de Solicitud *</label>
                        <select id="tipo_solicitud_id" name="tipo_solicitud_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Seleccionar tipo</option>
                            @foreach($tipoSolicitudes as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_solicitud_id', $ticket->tipo_solicitud_id) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->tipo_solicitud }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_solicitud_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles de la Resolución -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Detalles de la Resolución
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label for="incidencia_real" class="block text-sm font-medium text-gray-700">Incidencia Real *</label>
                        <textarea id="incidencia_real" name="incidencia_real" rows="4" required 
                                  placeholder="Describa cuál fue el problema real encontrado..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('incidencia_real', $ticket->incidencia_real) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Describa detalladamente cuál fue el problema real que se encontró</p>
                        @error('incidencia_real')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="servicio_realizado" class="block text-sm font-medium text-gray-700">Servicio Realizado *</label>
                        <textarea id="servicio_realizado" name="servicio_realizado" rows="4" required 
                                  placeholder="Describa detalladamente las acciones realizadas para resolver el ticket..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('servicio_realizado', $ticket->servicio_realizado) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Explique paso a paso qué se hizo para resolver el problema</p>
                        @error('servicio_realizado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones Adicionales</label>
                        <textarea id="observaciones" name="observaciones" rows="3" 
                                  placeholder="Cualquier observación adicional, recomendaciones, o comentarios..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('observaciones', $ticket->observaciones) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Campo opcional para observaciones, recomendaciones o comentarios adicionales</p>
                    </div>

                    <div>
                        <label for="fecha_atencion" class="block text-sm font-medium text-gray-700">Fecha de Atención</label>
                        <input type="datetime-local" id="fecha_atencion" name="fecha_atencion" 
                               value="{{ old('fecha_atencion', $ticket->fecha_atencion ? \Carbon\Carbon::parse($ticket->fecha_atencion)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <p class="mt-1 text-xs text-gray-500">Por defecto se usa la fecha y hora actuales</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-3">
                    <div class="flex space-x-3">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-check-circle mr-2"></i>
                            Completar y Marcar como Resuelto
                        </button>
                        
                        <button type="button" onclick="saveDraft()" class="inline-flex items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>
                            Guardar Borrador
                        </button>
                    </div>
                    
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script para funcionalidades del formulario -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Guardar borrador sin marcar como resuelto
    window.saveDraft = function() {
        const form = document.querySelector('form');
        const originalAction = form.action;
        
        // Cambiar la ruta temporalmente para guardar borrador
        form.action = '{{ route("tickets.update", $ticket->id) }}';
        
        // Enviar formulario
        form.submit();
    };
    
    // Confirmación antes de completar
    const completeButton = document.querySelector('button[type="submit"]');
    completeButton.addEventListener('click', function(e) {
        if (!confirm('¿Está seguro de que desea completar este ticket? Una vez marcado como resuelto, el estado será definitivo.')) {
            e.preventDefault();
        }
    });
    
    // Validación en tiempo real
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
            }
        });
        
        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
            }
        });
    });
    
    // Auto-save cada 2 minutos
    setInterval(function() {
        // Solo auto-guardar si hay cambios
        const hasChanges = Array.from(requiredFields).some(field => field.value.trim());
        if (hasChanges) {
            console.log('Auto-guardando borrador...');
            // Podrías implementar auto-save aquí con AJAX
        }
    }, 120000); // 2 minutos
});
</script>
@endsection
