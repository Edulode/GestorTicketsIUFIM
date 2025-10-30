@extends('layouts.authenticated')

@section('title', 'Nueva Subárea')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nueva Subárea</h1>
                <p class="mt-2 text-sm text-gray-700">Crea una nueva subárea organizacional</p>
            </div>
            <div class="flex space-x-3">
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
    <form method="POST" action="{{ route('subareas.store') }}" class="space-y-6">
        @csrf

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
                        <input type="text" id="subarea" name="subarea" value="{{ old('subarea') }}" required
                               placeholder="Ej: Oficina A, Laboratorio 1, Aula 201..."
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('subarea')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Ingrese el nombre específico de la subárea o lugar.</p>
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
                        Crear Subárea
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
