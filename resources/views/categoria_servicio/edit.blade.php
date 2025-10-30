@extends('layouts.authenticated')

@section('title', 'Editar Categoría de Servicio')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-3">
            <a href="{{ route('categorias-servicio.index') }}" 
               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Categoría de Servicio</h1>
                <p class="mt-2 text-sm text-gray-600">Modifica los datos de la categoría "{{ $categoria->categoria_servicio }}"</p>
            </div>
        </div>
    </div>

    <!-- Alertas -->
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

    <!-- Información Actual -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder-open text-blue-600"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-900">Categoría Actual</h3>
                <p class="text-sm text-gray-600">{{ $categoria->categoria_servicio }}</p>
            </div>
            <div class="ml-auto text-right">
                <p class="text-xs text-gray-500">ID: #{{ $categoria->id }}</p>
                @if($categoria->created_at)
                    <p class="text-xs text-gray-500">Creada: {{ $categoria->created_at->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-edit mr-2"></i>
                Información de la Categoría
            </h3>
            <p class="mt-1 text-sm text-gray-600">Actualice los datos de la categoría de servicio</p>
        </div>
        
        <form action="{{ route('categorias-servicio.update', $categoria->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nombre de la Categoría -->
                <div>
                    <label for="categoria_servicio" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-folder-open mr-1"></i>
                        Nombre de la Categoría *
                    </label>
                    <div class="mt-1">
                        <input type="text" 
                               id="categoria_servicio" 
                               name="categoria_servicio" 
                               value="{{ old('categoria_servicio', $categoria->categoria_servicio) }}"
                               maxlength="255"
                               required
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('categoria_servicio') border-red-300 @enderror"
                               placeholder="Ej: Soporte Técnico, Administración, Académico, etc.">
                    </div>
                    @error('categoria_servicio')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        Ingrese un nombre descriptivo para la categoría de servicio (máximo 255 caracteres)
                    </p>
                </div>

                <!-- Estadísticas de Uso -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-bar text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Uso de la Categoría</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <span class="font-medium">Tipos de Solicitud:</span>
                                        <span class="ml-2">{{ $categoria->tiposSolicitud->count() ?? 0 }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Tickets Asociados:</span>
                                        <span class="ml-2">{{ $categoria->tickets->count() ?? 0 }}</span>
                                    </div>
                                </div>
                                @if($categoria->tiposSolicitud->count() > 0 || $categoria->tickets->count() > 0)
                                    <p class="mt-2 text-xs">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Esta categoría está siendo utilizada. Los cambios se reflejarán en todos los elementos asociados.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('categorias-servicio.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Categoría
                </button>
            </div>
        </form>
    </div>

    <!-- Vista Previa de Cambios -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-eye mr-2"></i>
                Vista Previa de Cambios
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Antes -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Antes</h4>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-folder-open text-gray-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $categoria->categoria_servicio }}</p>
                                <p class="text-xs text-gray-500">Versión actual</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Después -->
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Después</h4>
                    <div class="border-2 border-dashed border-blue-300 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-folder-open text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900" id="preview-name">{{ $categoria->categoria_servicio }}</p>
                                <p class="text-xs text-gray-500">Nueva versión</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tipos de Solicitud Asociados -->
    @if($categoria->tiposSolicitud->count() > 0)
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-link mr-2"></i>
                    Tipos de Solicitud Asociados ({{ $categoria->tiposSolicitud->count() }})
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categoria->tiposSolicitud as $tipo)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-tag text-green-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-3 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $tipo->tipo_solicitud }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Script para vista previa en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaInput = document.getElementById('categoria_servicio');
    const previewName = document.getElementById('preview-name');
    const originalValue = categoriaInput.value;
    
    // Actualizar vista previa en tiempo real
    categoriaInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewName.textContent = value || originalValue;
    });
    
    // Validación en tiempo real
    categoriaInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value.length > 255) {
            this.classList.add('border-red-300');
        } else {
            this.classList.remove('border-red-300');
        }
    });
    
    // Auto-focus en el campo principal
    categoriaInput.focus();
    categoriaInput.select();
    
    // Confirmar antes de salir si hay cambios sin guardar
    let hasChanges = false;
    categoriaInput.addEventListener('input', function() {
        hasChanges = this.value !== originalValue;
    });
    
    // Advertir si intenta salir sin guardar
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '¿Está seguro de que desea salir? Los cambios no guardados se perderán.';
        }
    });
    
    // No mostrar advertencia al enviar el formulario
    document.querySelector('form').addEventListener('submit', function() {
        hasChanges = false;
    });
    
    // No mostrar advertencia al hacer clic en cancelar
    document.querySelector('a[href*="categorias-servicio.index"]').addEventListener('click', function(e) {
        if (hasChanges) {
            if (!confirm('¿Está seguro de que desea cancelar? Los cambios no guardados se perderán.')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection
