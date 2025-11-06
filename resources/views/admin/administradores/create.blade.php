@extends('layouts.authenticated')

@section('title', 'Nuevo Administrador')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nuevo Administrador</h1>
                <p class="mt-2 text-sm text-gray-700">Crear una nueva cuenta de administrador con acceso al sistema</p>
            </div>
            <a href="{{ route('admin.administradores.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a la lista
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Información del Administrador
            </h3>
        </div>

        <form action="{{ route('admin.administradores.store') }}" method="POST" class="p-6">
            @csrf
            
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
                               value="{{ old('name') }}"
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
                               value="{{ old('email') }}"
                               required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               placeholder="example@iufim.com.mx">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Este será el email para iniciar sesión en el sistema
                        </p>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1"></i>
                            Contraseña *
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
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
                        <div class="mt-1">
                            <div class="text-xs text-gray-500 mb-1">Se sugiere tener:</div>
                            <ul class="text-xs text-gray-500 list-disc list-inside space-y-1">
                                <li>Mínimo 8 caracteres</li>
                                <li>Recomendado: mayúsculas, minúsculas, números y símbolos</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1"></i>
                            Confirmar Contraseña *
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Repetir la contraseña">
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
            </div>

            <!-- Vista Previa -->
            <div class="mb-8 bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                <h4 class="text-sm font-medium text-indigo-900 mb-2 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Vista Previa del Administrador
                </h4>
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="preview-initials">--</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900" id="preview-name">Nombre completo aparecerá aquí</div>
                        <div class="text-xs text-gray-500" id="preview-email">email@ejemplo.com</div>
                        <div class="text-xs text-indigo-600">Administrador del Sistema</div>
                    </div>
                </div>
            </div>

            

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.administradores.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition">
                    <i class="fas fa-save mr-2"></i>
                    Crear Administrador
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
        if (passwordInput.value && confirmPasswordInput.value) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }
    }

    passwordInput.addEventListener('input', validatePasswords);
    confirmPasswordInput.addEventListener('input', validatePasswords);
});

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