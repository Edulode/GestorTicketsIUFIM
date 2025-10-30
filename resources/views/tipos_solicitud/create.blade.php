@extends('layouts.authenticated')

@section('title', 'Nuevo Tipo de Solicitud')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nuevo Tipo de Solicitud</h1>
                <p class="mt-2 text-sm text-gray-700">Crea un nuevo tipo de solicitud para clasificar tickets</p>
            </div>
            <div class="flex space-x-3">
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

    <!-- Formulario -->
    <form method="POST" action="{{ route('tipos_solicitud.store') }}" class="space-y-6">
        @csrf

        <!-- Información del Tipo de Solicitud -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-clipboard-list mr-2"></i>
                    Información del Tipo de Solicitud
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label for="tipo_solicitud" class="block text-sm font-medium text-gray-700">Nombre del Tipo de Solicitud *</label>
                        <input type="text" id="tipo_solicitud" name="tipo_solicitud" value="{{ old('tipo_solicitud') }}" required
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
                                <option value="{{ $categoria->id }}" {{ old('categoria_servicio_id') == $categoria->id ? 'selected' : '' }}>
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
                        Crear Tipo de Solicitud
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script para validación en tiempo real y vista previa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoInput = document.getElementById('tipo_solicitud');
    const categoriaSelect = document.getElementById('categoria_servicio_id');
    const previewTipo = document.getElementById('preview-tipo');
    const previewCategoria = document.getElementById('preview-categoria');
    
    // Actualizar vista previa en tiempo real
    tipoInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewTipo.textContent = value || 'Ingrese el nombre del tipo de solicitud';
    });
    
    categoriaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        previewCategoria.textContent = selectedOption.text === 'Seleccione una categoría...' ? 
            'Seleccione una categoría de servicio' : 
            'Categoría: ' + selectedOption.text;
    });
    
    // Validación para el campo tipo de solicitud
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

    // Validación para categoría
    categoriaSelect.addEventListener('change', function() {
        if (this.value) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-green-500');
            this.classList.add('border-red-500');
        }
    });

    // Auto-focus en el primer campo
    tipoInput.focus();
});
</script>
@endsection
