@extends('layouts.authenticated')

@section('title', 'Editar Área')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Área</h1>
                <p class="mt-2 text-sm text-gray-700">Modifica la información del área: {{ $area->area }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('areas.show', $area->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Área
                </a>
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
    <form method="POST" action="{{ route('areas.update', $area->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

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
                        <input type="text" id="area" name="area" value="{{ old('area', $area->area) }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Nombre oficial del área organizacional.</p>
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
                        <label class="block text-sm font-medium text-gray-700">ID del Área</label>
                        <p class="mt-1 text-sm text-gray-900">#{{ $area->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $area->created_at ? $area->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $area->updated_at ? $area->updated_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usuarios Asignados</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $area->usuarios->count() }} usuario(s)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios Actuales -->
        @if($area->usuarios->count() > 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-users mr-2"></i>
                    Elementos Asociados
                </h3>
            </div>
            <div class="p-6">
                @if($area->usuarios->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Usuarios Asignados ({{ $area->usuarios->count() }})</h4>
                        <div class="space-y-2">
                            @foreach($area->usuarios->take(5) as $usuario)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $usuario->nombre }} {{ $usuario->apellido_paterno }}
                                    @if($usuario->email)
                                        <span class="text-gray-400 ml-2">({{ $usuario->email }})</span>
                                    @endif
                                </div>
                            @endforeach
                            @if($area->usuarios->count() > 5)
                                <p class="text-sm text-gray-500">Y {{ $area->usuarios->count() - 5 }} usuario(s) más...</p>
                            @endif
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
