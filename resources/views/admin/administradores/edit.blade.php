@extends('layouts.authenticated')

@section('title', 'Editar Administrador')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Administrador</h1>
                <p class="mt-2 text-sm text-gray-700">Modificar la información del administrador: {{ $user->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.administradores.show', $user->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Detalles
                </a>
                <a href="{{ route('admin.administradores.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-user-edit mr-2"></i>
                Editar Información del Administrador
            </h3>
        </div>

        <form action="{{ route('admin.administradores.update', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Información Personal -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-id-card mr-2 text-indigo-500"></i>
                    Datos Personales
                </h4>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nombre completo -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1"></i>
                            Nombre Completo *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="Ej: Juan Pérez González">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Credenciales de Acceso -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-key mr-2 text-indigo-500"></i>
                    Credenciales de Acceso
                </h4>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1"></i>
                            Correo Electrónico *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="admin@iufim.edu.mx">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Este será el email para iniciar sesión en el sistema
                        </p>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="text-sm font-medium text-gray-900">Cambiar Contraseña</h5>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="change_password" 
                                       name="change_password" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                       onchange="togglePasswordFields()">
                                <label for="change_password" class="ml-2 text-sm text-gray-700">
                                    Cambiar contraseña
                                </label>
                            </div>
                        </div>

                        <div id="password-fields" class="hidden space-y-4">
                            <!-- Nueva Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-1"></i>
                                    Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           minlength="8"
                                           class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           placeholder="Mínimo 8 caracteres">
                                    <button type="button" 
                                            onclick="togglePassword('password')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password-icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Nueva Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-1"></i>
                                    Confirmar Nueva Contraseña
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           placeholder="Repetir la nueva contraseña">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Deja sin marcar si no deseas cambiar la contraseña actual
                        </p>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="mb-8">
                <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-indigo-500"></i>
                    Información del Sistema
                </h4>
                
                <div class="bg-gray-50 p-4 rounded-lg grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID del Usuario</label>
                        <p class="text-sm text-gray-600">#{{ $user->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro</label>
                        <p class="text-sm text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Última Actualización</label>
                        <p class="text-sm text-gray-600">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                </div>
            </div>

            <!-- Vista Previa -->
            <div class="mb-8 bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                <h4 class="text-sm font-medium text-indigo-900 mb-2 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa Actualizada
                </h4>
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="preview-initials">
                            {{ substr(collect(explode(' ', $user->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->implode(''), 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900" id="preview-name">{{ $user->name }}</div>
                        <div class="text-xs text-gray-500" id="preview-email">{{ $user->email }}</div>
                        <div class="text-xs text-indigo-600">Administrador del Sistema</div>
                    </div>
                </div>
            </div>

            <!-- Información de Seguridad -->
            @if(auth()->user()->id === $user->id)
            <div class="mb-8 bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex">
                    <i class="fas fa-user-shield text-blue-500 mt-0.5 mr-2"></i>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Editando tu propia cuenta</p>
                        <p class="text-xs">Estás modificando tu propia información de administrador. Los cambios se aplicarán inmediatamente.</p>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-8 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <div class="flex">
                    <i class="fas fa-shield-alt text-yellow-500 mt-0.5 mr-2"></i>
                    <div class="text-sm text-yellow-700">
                        <p class="font-medium mb-2">Precauciones de Seguridad:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Verifica que los cambios son correctos antes de guardar</li>
                            <li>El cambio de email podría afectar las notificaciones del sistema</li>
                            <li>Si cambias la contraseña, informa al administrador afectado</li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.administradores.show', $user->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para funcionalidades interactivas -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const previewName = document.getElementById('preview-name');
    const previewEmail = document.getElementById('preview-email');
    const previewInitials = document.getElementById('preview-initials');

    function updatePreview() {
        const nombre = nameInput.value.trim();
        const email = emailInput.value.trim();
        
        // Actualizar nombre
        previewName.textContent = nombre || 'Nombre completo aparecerá aquí';
        
        // Actualizar email
        previewEmail.textContent = email || 'email@ejemplo.com';
        
        // Actualizar iniciales
        if (nombre) {
            const words = nombre.split(' ').filter(word => word.length > 0);
            const iniciales = words.map(word => word[0]).join('').toUpperCase().substring(0, 2);
            previewInitials.textContent = iniciales || '--';
        } else {
            previewInitials.textContent = '--';
        }
    }

    // Eventos para actualizar la vista previa
    nameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);

    // Validación de contraseñas en tiempo real
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');

    function validatePasswords() {
        const changePasswordChecked = document.getElementById('change_password').checked;
        
        if (changePasswordChecked && passwordInput.value && confirmPasswordInput.value) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    }

    if (passwordInput && confirmPasswordInput) {
        passwordInput.addEventListener('input', validatePasswords);
        confirmPasswordInput.addEventListener('input', validatePasswords);
    }
});

// Función para mostrar/ocultar campos de contraseña
function togglePasswordFields() {
    const checkbox = document.getElementById('change_password');
    const fields = document.getElementById('password-fields');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    if (checkbox.checked) {
        fields.classList.remove('hidden');
        passwordInput.required = true;
        confirmPasswordInput.required = true;
    } else {
        fields.classList.add('hidden');
        passwordInput.required = false;
        confirmPasswordInput.required = false;
        passwordInput.value = '';
        confirmPasswordInput.value = '';
    }
}

// Función para mostrar/ocultar contraseñas
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600';
    } else {
        field.type = 'password';
        icon.className = 'fas fa-eye text-gray-400 hover:text-gray-600';
    }
}
</script>

@endsection