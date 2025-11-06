@extends('layouts.authenticated')

@section('title', 'Gestión de Técnicos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Técnicos</h1>
            <p class="mt-2 text-sm text-gray-700">Gestión del personal técnico para atención de tickets</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('tecnicos.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Técnico
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
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Técnicos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tecnicos->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-user-check text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Activos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tecnicos->where('status', true)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-user-times text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Inactivos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tecnicos->where('status', false)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-tasks text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Con Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tecnicos->filter(function($t) { return $t->tickets->count() > 0; })->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Técnicos Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-list mr-2"></i>
                Lista de Técnicos
            </h3>
        </div>
        
        @if($tecnicos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Técnico
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tickets Asignados
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha Registro
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tecnicos as $tecnico)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellidoP, 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: #{{ $tecnico->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tecnico->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $tecnico->tickets->count() }}</span>
                                        @if($tecnico->tickets->count() > 0)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                tickets
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $tecnico->created_at ? $tecnico->created_at->format('d/m/Y') : 'No disponible' }}
                                        </td>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('tecnicos.show', $tecnico->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tecnicos.edit', $tecnico->id) }}" 
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
                        Mostrando <span class="font-medium">{{ $tecnicos->firstItem() ?? 0 }}</span> a <span class="font-medium">{{ $tecnicos->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $tecnicos->total() }}</span> técnicos
                    </div>
                    <div>
                        {{ $tecnicos->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay técnicos registrados</h3>
                <p class="text-gray-500 mb-6">Comienza agregando el primer técnico al sistema.</p>
                <a href="{{ route('tecnicos.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primer Técnico
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
                Confirmar Eliminación
            </h3>
            
            <!-- Información del técnico -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-red-400 to-red-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-white" id="modalInitials">--</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900" id="modalTecnicoName">Nombre del técnico</p>
                        <p class="text-xs text-gray-500">ID: #<span id="modalTecnicoId">0</span></p>
                    </div>
                </div>
            </div>
            
            <!-- Mensaje de confirmación -->
            <div class="text-sm text-gray-600 mb-4">
                <p class="mb-2"><strong>¿Está seguro de que desea eliminar este técnico?</strong></p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5 mr-2 text-sm"></i>
                        <div class="text-xs text-yellow-700">
                            <p class="font-medium">Esta acción es permanente e irreversible:</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>El técnico será eliminado completamente del sistema</li>
                                <li id="ticketsWarning" class="text-red-600 font-medium hidden">X tickets quedarán sin técnico asignado</li>
                                <li>No se podrá recuperar esta información</li>
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
let currentTecnicoId = null;

function openDeleteModal(tecnicoId, tecnicoName, ticketsCount) {
    currentTecnicoId = tecnicoId;
    
    // Actualizar información del técnico en el modal
    document.getElementById('modalTecnicoName').textContent = tecnicoName;
    document.getElementById('modalTecnicoId').textContent = tecnicoId;
    
    // Generar iniciales
    const names = tecnicoName.trim().split(' ');
    const initials = names.length >= 2 ? (names[0][0] + names[1][0]).toUpperCase() : names[0][0].toUpperCase();
    document.getElementById('modalInitials').textContent = initials;
    
    // Mostrar advertencia de tickets si corresponde
    const ticketsWarning = document.getElementById('ticketsWarning');
    if (ticketsCount > 0) {
        ticketsWarning.textContent = `${ticketsCount} tickets quedarán sin técnico asignado`;
        ticketsWarning.classList.remove('hidden');
    } else {
        ticketsWarning.classList.add('hidden');
    }
    
    // Actualizar action del formulario
    document.getElementById('deleteForm').action = `/tecnicos/${tecnicoId}`;
    
    // Mostrar modal
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    currentTecnicoId = null;
}

function confirmDelete() {
    if (currentTecnicoId) {
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