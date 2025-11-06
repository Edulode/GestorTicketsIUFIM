@extends('layouts.authenticated')

@section('title', 'Editar Técnico')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Técnico</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Modificar información de: 
                    <span class="font-medium text-blue-600">{{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}</span>
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tecnicos.show', $tecnico->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-eye mr-2"></i>
                    Ver detalles
                </a>
                <a href="{{ route('tecnicos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-user-edit mr-2"></i>
                Actualizar Información del Técnico
            </h3>
        </div>

        <form action="{{ route('tecnicos.update', $tecnico->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Información Actual -->
            <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Información Actual
                </h4>
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center mr-4">
                        <span class="text-sm font-medium text-white">
                            {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellidoP, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}</div>
                        <div class="text-xs text-gray-500 flex items-center">
                            <span class="mr-4">ID: #{{ $tecnico->id }}</span>
                            @if($tecnico->status)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1" style="font-size: 4px;"></i>
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-circle mr-1" style="font-size: 4px;"></i>
                                    Inactivo
                                </span>
                            @endif
                            <span class="ml-4">{{ $tecnico->tickets->count() }} tickets asignados</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Información Personal -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card mr-2 text-green-500"></i>
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
                               value="{{ old('name', $tecnico->nombre) }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
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
                               value="{{ old('apellidoP', $tecnico->apellidoP) }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
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
                               value="{{ old('apellidoM', $tecnico->apellidoM) }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
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
                    <i class="fas fa-toggle-on mr-2 text-green-500"></i>
                    Estado del Técnico
                </h4>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="status" 
                               name="status" 
                               value="1"
                               {{ old('status', $tecnico->status) ? 'checked' : '' }}
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="status" class="ml-3 block text-sm font-medium text-gray-700">
                            <span class="flex items-center">
                                <i class="fas fa-user-check mr-2 text-green-500"></i>
                                Técnico activo
                                <span class="ml-2 text-xs text-gray-500">(puede recibir asignación de tickets)</span>
                            </span>
                        </label>
                    </div>
                    @if($tecnico->tickets->count() > 0)
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5 mr-2"></i>
                                <div class="text-xs text-yellow-700">
                                    <strong>Nota:</strong> Este técnico tiene {{ $tecnico->tickets->count() }} tickets asignados. 
                                    Si lo desactivas, no podrá recibir nuevos tickets, pero los existentes permanecerán asignados.
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="mt-2 text-xs text-gray-600">
                            Los técnicos inactivos no podrán ser asignados a nuevos tickets
                        </p>
                    @endif
                </div>
            </div>

            <!-- Vista Previa -->
            <div class="mb-8 bg-green-50 p-4 rounded-lg border border-green-200">
                <h4 class="text-sm font-medium text-green-900 mb-2 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa de Cambios
                </h4>
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="preview-initials">
                            {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellidoP, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900" id="preview-name">
                            {{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}
                        </div>
                        <div class="text-xs text-gray-500">Técnico del sistema</div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('tecnicos.show', $tecnico->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    <i class="fas fa-eye mr-2"></i>
                    Ver detalles
                </a>
                <a href="{{ route('tecnicos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i>
                    Actualizar Técnico
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