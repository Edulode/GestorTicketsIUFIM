@extends('layouts.authenticated')

@section('title', 'Editar Tipo de Solicitud')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Tipo de Solicitud</h1>
                <p class="mt-2 text-sm text-gray-700">Modifica los datos del tipo "{{ $tipoSolicitud->tipo_solicitud }}"</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tipos_solicitud.show', $tipoSolicitud->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Detalles
                </a>
                <a href="{{ route('tipos_solicitud.index') }}" 
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Actual -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900">Tipo de Solicitud Actual</h3>
                        <p class="text-sm text-gray-600">{{ $tipoSolicitud->tipo_solicitud }}</p>
                        <p class="text-xs text-gray-500">
                            Categoría: {{ $tipoSolicitud->categoriaServicio->categoria_servicio ?? 'Sin categoría' }}
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-xs text-gray-500">ID: #{{ $tipoSolicitud->id }}</p>
                        @if($tipoSolicitud->created_at)
                            <p class="text-xs text-gray-500">Creado: {{ $tipoSolicitud->created_at->format('d/m/Y') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('tipos_solicitud.update', $tipoSolicitud->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-edit mr-2"></i>
                            Información del Tipo de Solicitud
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <div>
                                <label for="tipo_solicitud" class="block text-sm font-medium text-gray-700">Nombre del Tipo de Solicitud *</label>
                                <input type="text" id="tipo_solicitud" name="tipo_solicitud" 
                                       value="{{ old('tipo_solicitud', $tipoSolicitud->tipo_solicitud) }}" required
                                       placeholder="Ej: Mantenimiento, Capacitación, Reporte de Falla..."
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('tipo_solicitud')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Ingrese el nombre específico del tipo de solicitud.</p>
                            </div>

                            <div>
                                <label for="categoria_servicio_id" class="block text-sm font-medium text-gray-700">Categoría de Servicio *</label>
                                <select id="categoria_servicio_id" name="categoria_servicio_id" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Seleccione una categoría...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                                {{ old('categoria_servicio_id', $tipoSolicitud->categoria_servicio_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->categoria_servicio }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_servicio_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Seleccione la categoría bajo la cual se clasificará este tipo de solicitud.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advertencias sobre Tickets -->
                @if($tipoSolicitud->tickets->count() > 0)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Advertencia sobre Tickets Asociados</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Este tipo de solicitud tiene <strong>{{ $tipoSolicitud->tickets->count() }} ticket(s)</strong> asociado(s).</p>
                                    <p class="mt-1">Los cambios realizados se reflejarán en todos los tickets que utilicen este tipo de solicitud.</p>
                                </div>
                            </div>
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
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-save mr-2"></i>
                                Actualizar Tipo de Solicitud
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel Lateral -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Vista Previa de Cambios -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-eye mr-2"></i>
                        Vista Previa
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Antes -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Antes</h4>
                            <div class="border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-clipboard-list text-gray-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $tipoSolicitud->tipo_solicitud }}</p>
                                        <p class="text-xs text-gray-500">{{ $tipoSolicitud->categoriaServicio->categoria_servicio ?? 'Sin categoría' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Después -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Después</h4>
                            <div class="border-2 border-dashed border-blue-300 rounded-lg p-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-clipboard-list text-blue-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900" id="preview-tipo">{{ $tipoSolicitud->tipo_solicitud }}</p>
                                        <p class="text-xs text-gray-500" id="preview-categoria">{{ $tipoSolicitud->categoriaServicio->categoria_servicio ?? 'Sin categoría' }}</p>
                                    </div>
                                </div>
                            </div>
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
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">ID:</span>
                            <span class="font-medium">#{{ $tipoSolicitud->id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tickets:</span>
                            <span class="font-medium">{{ $tipoSolicitud->tickets->count() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Creado:</span>
                            <span class="font-medium">{{ $tipoSolicitud->created_at ? $tipoSolicitud->created_at->format('d/m/Y H:i') : 'No disponible' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Actualizado:</span>
                            <span class="font-medium">{{ $tipoSolicitud->updated_at ? $tipoSolicitud->updated_at->format('d/m/Y H:i') : 'No disponible' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para vista previa en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoInput = document.getElementById('tipo_solicitud');
    const categoriaSelect = document.getElementById('categoria_servicio_id');
    const previewTipo = document.getElementById('preview-tipo');
    const previewCategoria = document.getElementById('preview-categoria');
    const originalTipo = tipoInput.value;
    const originalCategoria = categoriaSelect.options[categoriaSelect.selectedIndex].text;
    
    // Actualizar vista previa en tiempo real
    tipoInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewTipo.textContent = value || originalTipo;
    });
    
    categoriaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        previewCategoria.textContent = selectedOption.text === 'Seleccione una categoría...' ? 
            'Sin categoría' : 
            selectedOption.text;
    });
    
    // Validación en tiempo real
    tipoInput.addEventListener('blur', function() {
        if (!this.value.trim()) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        }
    });
    
    tipoInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-green-500');
        }
    });

    // Auto-focus y selección del texto
    tipoInput.focus();
    tipoInput.select();
});
</script>
@endsection
