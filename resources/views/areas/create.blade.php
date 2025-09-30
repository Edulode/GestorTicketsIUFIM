@extends('layouts.authenticated')

@section('title', 'Nueva Área')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nueva Área</h1>
                <p class="mt-2 text-sm text-gray-700">Crea una nueva área organizacional</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('areas.index') }}" 
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
    <form method="POST" action="{{ route('areas.store') }}" class="space-y-6">
        @csrf

        <!-- Información del Área -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-building mr-2"></i>
                    Información del Área
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700">Nombre del Área *</label>
                        <input type="text" id="area" name="area" value="{{ old('area') }}" required
                               placeholder="Ej: Recursos Humanos, Tecnología, Administración..."
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Ingrese el nombre oficial del área organizacional.</p>
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="4" 
                                  placeholder="Describe las responsabilidades y funciones principales del área..."
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Opcional. Proporcione una descripción detallada del área y sus responsabilidades.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-info-circle mr-2"></i>
                    Información Adicional
                </h3>
            </div>
            <div class="p-6">
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Consejos para crear áreas:</h4>
                            <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                                <li>Use nombres descriptivos y oficiales del área</li>
                                <li>Evite abreviaciones que puedan ser confusas</li>
                                <li>Una vez creada, podrá asignar usuarios y crear subáreas</li>
                                <li>Las áreas se utilizarán para organizar tickets y usuarios</li>
                                <li>Puede agregar una descripción detallada para mayor claridad</li>
                            </ul>
                        </div>
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
                        Crear Área
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script para validación en tiempo real -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const areaInput = document.getElementById('area');
    const descripcionInput = document.getElementById('descripcion');
    
    // Validación para el campo área
    areaInput.addEventListener('blur', function() {
        if (!this.value.trim()) {
            this.classList.add('border-red-500');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        }
    });
    
    areaInput.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-green-500');
        }
    });

    // Contador de caracteres para descripción
    descripcionInput.addEventListener('input', function() {
        const maxLength = 500;
        const currentLength = this.value.length;
        
        // Crear o actualizar contador si no existe
        let contador = document.getElementById('contador-descripcion');
        if (!contador) {
            contador = document.createElement('p');
            contador.id = 'contador-descripcion';
            contador.className = 'mt-1 text-sm text-gray-500';
            this.parentNode.appendChild(contador);
        }
        
        contador.textContent = `${currentLength}/${maxLength} caracteres`;
        
        if (currentLength > maxLength) {
            contador.className = 'mt-1 text-sm text-red-600';
            this.classList.add('border-red-500');
        } else {
            contador.className = 'mt-1 text-sm text-gray-500';
            this.classList.remove('border-red-500');
        }
    });
});
</script>
@endsection
