@extends('layouts.authenticated')

@section('title', 'Nuevo Técnico')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nuevo Técnico</h1>
                <p class="mt-2 text-sm text-gray-700">Agregar un nuevo técnico al sistema</p>
            </div>
            <a href="{{ route('tecnicos.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a la lista
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Información del Técnico
            </h3>
        </div>

        <form action="{{ route('tecnicos.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Información Personal -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card mr-2 text-blue-500"></i>
                    Datos Personales
                </h4>
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Nombre *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Ingrese el nombre">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido Paterno -->
                    <div>
                        <label for="apellidoP" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Apellido Paterno *
                        </label>
                        <input type="text" 
                               id="apellidoP" 
                               name="apellidoP" 
                               value="{{ old('apellidoP') }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Ingrese el apellido paterno">
                        @error('apellidoP')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido Materno -->
                    <div>
                        <label for="apellidoM" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Apellido Materno *
                        </label>
                        <input type="text" 
                               id="apellidoM" 
                               name="apellidoM" 
                               value="{{ old('apellidoM') }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="Ingrese el apellido materno">
                        @error('apellidoM')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-toggle-on mr-2 text-blue-500"></i>
                    Estado del Técnico
                </h4>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="status" 
                               name="status" 
                               value="1"
                               {{ old('status') ? 'checked' : 'checked' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="status" class="ml-3 block text-sm font-medium text-gray-700">
                            <span class="flex items-center">
                                <i class="fas fa-user-check mr-2 text-green-500"></i>
                                Técnico activo
                                <span class="ml-2 text-xs text-gray-500">(puede recibir asignación de tickets)</span>
                            </span>
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-600">
                        Los técnicos inactivos no podrán ser asignados a nuevos tickets
                    </p>
                </div>
            </div>

            <!-- Vista Previa -->
            <div class="mb-8 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <h4 class="text-sm font-medium text-blue-900 mb-2 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa
                </h4>
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="preview-initials">--</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900" id="preview-name">Nombre completo aparecerá aquí</div>
                        <div class="text-xs text-gray-500">Técnico del sistema</div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tecnicos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i>
                    Crear Técnico
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para vista previa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const apellidoPInput = document.getElementById('apellidoP');
    const apellidoMInput = document.getElementById('apellidoM');
    const previewName = document.getElementById('preview-name');
    const previewInitials = document.getElementById('preview-initials');

    function updatePreview() {
        const nombre = nameInput.value.trim();
        const apellidoP = apellidoPInput.value.trim();
        const apellidoM = apellidoMInput.value.trim();
        
        // Actualizar nombre completo
        const nombreCompleto = [nombre, apellidoP, apellidoM].filter(n => n).join(' ');
        previewName.textContent = nombreCompleto || 'Nombre completo aparecerá aquí';
        
        // Actualizar iniciales
        const iniciales = (nombre.charAt(0) + apellidoP.charAt(0)).toUpperCase();
        previewInitials.textContent = iniciales || '--';
    }

    // Eventos para actualizar la vista previa
    nameInput.addEventListener('input', updatePreview);
    apellidoPInput.addEventListener('input', updatePreview);
    apellidoMInput.addEventListener('input', updatePreview);
});
</script>
@endsection