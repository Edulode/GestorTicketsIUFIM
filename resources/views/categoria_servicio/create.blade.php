@extends('layouts.authenticated')

@section('title', 'Nueva Categoría de Servicio')

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
                <h1 class="text-3xl font-bold text-gray-900">Nueva Categoría de Servicio</h1>
                <p class="mt-2 text-sm text-gray-600">Crea una nueva categoría para clasificar los tipos de solicitud</p>
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

    <!-- Formulario -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-plus-circle mr-2"></i>
                Información de la Categoría
            </h3>
            <p class="mt-1 text-sm text-gray-600">Complete los datos para crear una nueva categoría de servicio</p>
        </div>
        
        <form action="{{ route('categorias-servicio.store') }}" method="POST" class="p-6">
            @csrf
            
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
                               value="{{ old('categoria_servicio') }}"
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

                <!-- Información Adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Información importante</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>La categoría será utilizada para agrupar tipos de solicitud relacionados</li>
                                    <li>Una vez creada, podrá asignar tipos de solicitud a esta categoría</li>
                                    <li>El nombre debe ser único y descriptivo</li>
                                    <li>Podrá editar el nombre en cualquier momento</li>
                                </ul>
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
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>
                    Crear Categoría
                </button>
            </div>
        </form>
    </div>

    <!-- Vista Previa -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-eye mr-2"></i>
                Vista Previa
            </h3>
        </div>
        <div class="p-6">
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-folder-open text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2" id="preview-name">
                        Nombre de la categoría
                    </h4>
                    <p class="text-sm text-gray-500">
                        Esta será la nueva categoría de servicio que podrá utilizar para clasificar tipos de solicitud
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para vista previa en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoriaInput = document.getElementById('categoria_servicio');
    const previewName = document.getElementById('preview-name');
    
    // Actualizar vista previa en tiempo real
    categoriaInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewName.textContent = value || 'Nombre de la categoría';
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
    
    // Confirmar antes de salir si hay cambios sin guardar
    let hasChanges = false;
    categoriaInput.addEventListener('input', function() {
        hasChanges = true;
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
    document.querySelector('a[href*="categorias-servicio.index"]').addEventListener('click', function() {
        if (hasChanges) {
            if (!confirm('¿Está seguro de que desea cancelar? Los cambios no guardados se perderán.')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection
