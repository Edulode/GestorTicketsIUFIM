@extends('layouts.authenticated')

@section('title', 'Nuevo Ciclo')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nuevo Ciclo</h1>
                <p class="mt-2 text-sm text-gray-700">Crea un nuevo ciclo académico o temporal</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('ciclos.index') }}" 
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
    <form method="POST" action="{{ route('ciclos.store') }}" class="space-y-6">
        @csrf

        <!-- Información del Ciclo -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-calendar mr-2"></i>
                    Información del Ciclo
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label for="ciclo" class="block text-sm font-medium text-gray-700">Nombre del Ciclo *</label>
                        <input type="text" id="ciclo" name="ciclo" value="{{ old('ciclo') }}" required
                               placeholder="Ej: 2024-1, Enero-Abril 2024, Semestre A..."
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('ciclo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Ingrese el nombre o período del ciclo académico.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista Previa -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa
                </h3>
            </div>
            <div class="p-6">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                <i class="fas fa-calendar text-orange-600"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="text-sm font-medium text-gray-900" id="preview-ciclo">
                                Ingrese el nombre del ciclo
                            </h4>
                            <p class="text-sm text-gray-500">
                                Nuevo ciclo académico
                            </p>
                        </div>
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">Esta es una vista previa de cómo se verá el ciclo en el sistema.</p>
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
                        Crear Ciclo
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script para validación en tiempo real y vista previa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cicloInput = document.getElementById('ciclo');
    const previewCiclo = document.getElementById('preview-ciclo');
    
    // Actualizar vista previa en tiempo real
    cicloInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewCiclo.textContent = value || 'Ingrese el nombre del ciclo';
    });
    
    // Validación para el campo ciclo
    cicloInput.addEventListener('blur', function() {
        if (!this.value.trim()) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        }
    });
    
    cicloInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-green-500');
        }
    });

    // Auto-focus en el primer campo
    cicloInput.focus();
});
</script>
@endsection
