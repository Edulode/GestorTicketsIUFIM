@extends('layouts.authenticated')

@section('title', 'Detalles del Técnico')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalles del Técnico</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa y tickets asignados</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tecnicos.edit', $tecnico->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
                <a href="{{ route('tecnicos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información del Técnico -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        Información Personal
                    </h3>
                </div>
                
                <div class="p-6">
                    <!-- Avatar y nombre -->
                    <div class="flex items-center mb-6">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center mr-4">
                            <span class="text-xl font-bold text-white">
                                {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellidoP, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">{{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}</h4>
                            <p class="text-sm text-gray-500">Técnico del Sistema</p>
                            <div class="mt-2">
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
                            </div>
                        </div>
                    </div>

                    <!-- Detalles -->
                    <div class="space-y-4">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-id-badge text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-500">ID:</span>
                            <span class="ml-2 font-medium text-gray-900">#{{ $tecnico->id }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-plus text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-500">Registrado:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $tecnico->created_at ? $tecnico->created_at->format('d/m/Y H:i') : 'No disponible' }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-edit text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-500">Última actualización:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $tecnico->updated_at ? $tecnico->updated_at->format('d/m/Y H:i') : 'No disponible' }}</span>
                        </div>
                        
                        <div class="flex items-center text-sm">
                            <i class="fas fa-tasks text-gray-400 w-5"></i>
                            <span class="ml-3 text-gray-500">Tickets asignados:</span>
                            <span class="ml-2 font-medium text-gray-900">{{ $tecnico->tickets->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="mt-6 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Total de Tickets -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-ticket-alt text-blue-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-900">Total Tickets</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $tecnico->tickets->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Resueltos -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-900">Resueltos</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        {{ $tecnico->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status === 'Resuelto'; })->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Pendientes -->
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-900">Pendientes</p>
                                    <p class="text-2xl font-bold text-yellow-600">
                                        {{ $tecnico->tickets->filter(function($ticket) { return $ticket->status && $ticket->status->status === 'Pendiente'; })->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Asignados -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-indigo-600">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        Tickets Asignados ({{ $tecnico->tickets->count() }})
                    </h3>
                </div>
                
                @if($tecnico->tickets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ticket
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descripción
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estado
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($tecnico->tickets->sortByDesc('created_at') as $ticket)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-xs font-medium text-indigo-600">#{{ $ticket->id }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ Str::limit($ticket->solicitud, 50) }}</div>
                                            @if($ticket->usuario)
                                                <div class="text-xs text-gray-500">
                                                    {{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido_paterno }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($ticket->status)
                                                @php
                                                    $statusColors = [
                                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                        'Resuelto' => 'bg-green-100 text-green-800'
                                                    ];
                                                    $colorClass = $statusColors[$ticket->status->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                                    <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                                    {{ $ticket->status->status }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-question-circle mr-1"></i>
                                                    Sin Estado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($ticket->created_at)
                                                <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                                <div class="text-xs">{{ $ticket->created_at->format('H:i') }}</div>
                                            @else
                                                <div class="text-xs text-gray-400">Sin fecha</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('tickets.show', $ticket->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                                   title="Ver ticket">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('tickets.edit', $ticket->id) }}" 
                                                   class="text-green-600 hover:text-green-900 transition-colors duration-200" 
                                                   title="Editar ticket">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tickets asignados</h3>
                        <p class="text-gray-500">Este técnico no tiene tickets asignados actualmente.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Botones de acción adicionales -->
    <div class="mt-8 bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Acciones Adicionales</h3>
                <p class="text-sm text-gray-500">Operaciones disponibles para este técnico</p>
            </div>
            <div class="flex space-x-3">
                @if($tecnico->status)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Disponible para asignaciones
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i>
                        No disponible para asignaciones
                    </span>
                @endif
                
                <button type="button" 
                        onclick="openDeleteModal()"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar Técnico
                </button>
                
                <!-- Formulario oculto para eliminar -->
                <form id="deleteForm" action="{{ route('tecnicos.destroy', $tecnico->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
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
                        <span class="text-sm font-medium text-white">
                            {{ strtoupper(substr($tecnico->nombre, 0, 1) . substr($tecnico->apellidoP, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $tecnico->nombre }} {{ $tecnico->apellidoP }} {{ $tecnico->apellidoM }}</p>
                        <p class="text-xs text-gray-500">ID: #{{ $tecnico->id }}</p>
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
                                @if($tecnico->tickets->count() > 0)
                                    <li class="text-red-600 font-medium">{{ $tecnico->tickets->count() }} tickets quedarán sin técnico asignado</li>
                                @endif
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

<!-- JavaScript para el modal -->
<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevenir scroll del body
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restaurar scroll del body
}

function confirmDelete() {
    document.getElementById('deleteForm').submit();
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