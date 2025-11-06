@extends('layouts.authenticated')

@section('title', 'Detalles del Administrador')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalles del Administrador</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa de {{ $user->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.administradores.edit', $user->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('admin.administradores.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Perfil del Administrador -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-user-shield mr-2"></i>
                        Perfil del Administrador
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center mr-4">
                            <span class="text-xl font-bold text-white">
                                {{ substr(collect(explode(' ', $user->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->implode(''), 0, 2) }}
                            </span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-600">Administrador del Sistema</p>
                            
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1"></i>
                                Correo Electrónico
                            </label>
                            <div class="flex items-center">
                                <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded border flex-1">{{ $user->email }}</p>
                                
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-badge mr-1"></i>
                                ID de Usuario
                            </label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded border">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-cogs mr-2"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                Fecha de Registro
                            </label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded border">
                                {{ $user->created_at->format('d/m/Y H:i:s') }}
                                <span class="text-xs text-gray-500 block">
                                    ({{ $user->created_at->diffForHumans() }})
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check mr-1"></i>
                                Última Actualización
                            </label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-2 rounded border">
                                {{ $user->updated_at->format('d/m/Y H:i:s') }}
                                <span class="text-xs text-gray-500 block">
                                    ({{ $user->updated_at->diffForHumans() }})
                                </span>
                            </p>
                        </div>

                    

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-fingerprint mr-1"></i>
                                Estado de Seguridad
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    <span>Contraseña configurada</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial Reciente -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-history mr-2"></i>
                        Historial de Actividad
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Registro del usuario -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-user-plus text-green-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Cuenta creada</p>
                                <p class="text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y H:i') }} - 
                                    {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <!-- Última actualización si es diferente a la creación -->
                        @if($user->updated_at->format('Y-m-d H:i') !== $user->created_at->format('Y-m-d H:i'))
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-edit text-blue-600 text-sm"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Perfil actualizado</p>
                                <p class="text-sm text-gray-500">
                                    {{ $user->updated_at->format('d/m/Y H:i') }} - 
                                    {{ $user->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endif

                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Acciones Rápidas -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-500 to-gray-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.administradores.edit', $user->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Administrador
                    </a>
                    
                    @if(auth()->user()->id !== $user->id)
                    <button onclick="confirmDeleteAdmin({{ $user->id }}, '{{ $user->name }}')" 
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Eliminar Cuenta
                    </button>
                    @else
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-700 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Esta es tu cuenta actual
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Estadísticas Rápidas -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Tiempo en el sistema</span>
                        <span class="text-sm text-gray-900 font-semibold">
                            {{ $user->created_at->diffForHumans(null, true) }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Estado del perfil</span>
                        <span class="text-sm text-green-600 font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>
                            Activo
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Nivel de acceso</span>
                        <span class="text-sm text-indigo-600 font-semibold">
                            <i class="fas fa-crown mr-1"></i>
                            Administrador
                        </span>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
@if(auth()->user()->id !== $user->id)
<div id="deleteAdminModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Eliminar Administrador
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            ¿Estás seguro de que deseas eliminar al administrador <strong id="admin-name-modal"></strong>? 
                            Esta acción no se puede deshacer y el usuario perderá permanentemente el acceso al sistema.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <form id="deleteAdminForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition duration-200">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Sí, eliminar
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
function confirmDeleteAdmin(adminId, adminName) {
    document.getElementById('admin-name-modal').textContent = adminName;
    document.getElementById('deleteAdminForm').action = `/admin/administradores/${adminId}`;
    document.getElementById('deleteAdminModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteAdminModal').classList.add('hidden');
}

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>

@endsection