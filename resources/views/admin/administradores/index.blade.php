@extends('layouts.authenticated')

@section('title', 'Gestión de Administradores')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Administradores del Sistema</h1>
            <p class="mt-2 text-sm text-gray-700">Gestión de usuarios administradores con acceso al sistema</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.administradores.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                <i class="fas fa-user-plus mr-2"></i>
                Nuevo Administrador
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-user-shield text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Administradores</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $administradores->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Activos Hoy</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $administradores->where('updated_at', '>=', today())->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Administradores Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-list mr-2"></i>
                Lista de Administradores
            </h3>
        </div>
        
        @if($administradores->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Administrador
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Última Actividad
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($administradores as $admin)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-400 to-indigo-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $admin->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: #{{ $admin->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                                    
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $admin->updated_at ? $admin->updated_at->format('d/m/Y') : 'Nunca' }}</div>
                                    @if($admin->updated_at)
                                        <div class="text-xs">{{ $admin->updated_at->format('H:i') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.administradores.show', $admin->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.administradores.edit', $admin->id) }}" 
                                           class="text-green-600 hover:text-green-900 transition-colors duration-200" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Mostrando <span class="font-medium">{{ $administradores->firstItem() ?? 0 }}</span> a <span class="font-medium">{{ $administradores->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $administradores->total() }}</span> administradores
                    </div>
                    <div>
                        {{ $administradores->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay administradores registrados</h3>
                <p class="text-gray-500 mb-6">Comienza agregando el primer administrador al sistema.</p>
                <a href="{{ route('admin.administradores.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-user-plus mr-2"></i>
                    Crear Primer Administrador
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Icono de advertencia -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            
            <!-- Título -->
            <h3 class="text-lg font-bold text-gray-900 text-center mb-2">
                Confirmar Eliminación de Administrador
            </h3>
            
            <!-- Información del administrador -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="modalInitials">--</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900" id="modalAdminName">Nombre del administrador</p>
                        <p class="text-xs text-gray-500" id="modalAdminEmail">email@ejemplo.com</p>
                    </div>
                </div>
            </div>
            
            <!-- Mensaje de confirmación -->
            <div class="text-sm text-gray-600 mb-4">
                <p class="mb-2"><strong>¿Está seguro de que desea eliminar este administrador?</strong></p>
                <div class="bg-red-50 border border-red-200 rounded-md p-3">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5 mr-2 text-sm"></i>
                        <div class="text-xs text-red-700">
                            <p class="font-medium">⚠️ ATENCIÓN: Esta acción es irreversible:</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>Se eliminará permanentemente el acceso al sistema</li>
                                <li>Se perderán todas las sesiones activas</li>
                                <li>No se podrá recuperar esta cuenta</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button onclick="confirmDelete()" 
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    <i class="fas fa-trash mr-2"></i>
                    Sí, Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- JavaScript para el modal -->
<script>
let currentAdminId = null;

function openDeleteModal(adminId, adminName, adminEmail) {
    currentAdminId = adminId;
    
    // Actualizar información del administrador en el modal
    document.getElementById('modalAdminName').textContent = adminName;
    document.getElementById('modalAdminEmail').textContent = adminEmail;
    
    // Generar iniciales
    const initials = adminName.trim().split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
    document.getElementById('modalInitials').textContent = initials || '--';
    
    // Actualizar action del formulario
    document.getElementById('deleteForm').action = `/admin/administradores/${adminId}`;
    
    // Mostrar modal
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentAdminId = null;
}

function confirmDelete() {
    if (currentAdminId) {
        document.getElementById('deleteForm').submit();
    }
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>

@endsection