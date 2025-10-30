@extends('layouts.authenticated')

@section('title', 'Gestión de Ciclos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestión de Ciclos</h1>
                <p class="mt-2 text-sm text-gray-700">Administra los ciclos académicos del sistema</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('ciclos.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Ciclo
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-blue-100 rounded-md flex items-center justify-center">
                            <i class="fas fa-calendar text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Ciclos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $ciclos->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-green-100 rounded-md flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Con Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $ciclos->where('tickets_count', '>', 0)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-yellow-100 rounded-md flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sin Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $ciclos->where('tickets_count', 0)->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-purple-100 rounded-md flex items-center justify-center">
                            <i class="fas fa-chart-line text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Promedio Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $ciclos->count() > 0 ? number_format($ciclos->sum('tickets_count') / $ciclos->count(), 1) : 0 }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Lista de Ciclos -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($ciclos->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($ciclos as $ciclo)
                    <li class="hover:bg-gray-50 transition-colors duration-150">
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <!-- Avatar/Icono -->
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center">
                                            <i class="fas fa-calendar text-orange-600 text-lg"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Información Principal -->
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="{{ route('ciclos.show', $ciclo) }}" class="hover:text-blue-600">
                                                    {{ $ciclo->ciclo }}
                                                </a>
                                            </h3>
                                            <span class="ml-2 text-sm text-gray-500 font-mono">
                                                #{{ str_pad($ciclo->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-1 flex items-center text-sm text-gray-500 space-x-4">
                                            <span>
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                {{ $ciclo->tickets_count }} tickets
                                            </span>
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                Creado {{ $ciclo->created_at ? $ciclo->created_at->format('d/m/Y') : 'N/A' }}
                                            </span>
                                            @if($ciclo->updated_at && $ciclo->updated_at != $ciclo->created_at)
                                                <span>
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Actualizado {{ $ciclo->updated_at->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Badges y Acciones -->
                                <div class="flex items-center space-x-3">
                                    <!-- Badge de Estado -->
                                    @if($ciclo->tickets_count > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-circle mr-1"></i>
                                            Sin Actividad
                                        </span>
                                    @endif
                                    
                                    <!-- Acciones -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('ciclos.show', $ciclo) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ciclos.edit', $ciclo) }}" 
                                           class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($ciclo->tickets_count == 0)
                                            <button type="button" onclick="showDeleteModal({{ $ciclo->id }}, '{{ $ciclo->ciclo }}')" 
                                                    class="text-red-600 hover:text-red-900" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <span class="text-gray-400" title="No se puede eliminar - tiene tickets asociados">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            
            <!-- Paginación -->
            @if($ciclos->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $ciclos->links() }}
                </div>
            @endif
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <i class="fas fa-calendar text-4xl"></i>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay ciclos</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                        No se encontraron ciclos que coincidan con tu búsqueda.
                    @else
                        Comienza creando tu primer ciclo académico.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request('search'))
                        <a href="{{ route('ciclos.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-times mr-2"></i>
                            Limpiar búsqueda
                        </a>
                    @else
                        <a href="{{ route('ciclos.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-plus mr-2"></i>
                            Crear primer ciclo
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Confirmar Eliminación</h3>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">
                        ¿Estás seguro de que deseas eliminar el ciclo <strong id="deleteModalCicloName"></strong>?
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-6">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancelar
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Sí, Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentCicloId = null;

function showDeleteModal(cicloId, cicloName) {
    currentCicloId = cicloId;
    document.getElementById('deleteModalCicloName').textContent = '"' + cicloName + '"';
    document.getElementById('deleteForm').action = `/ciclos/${cicloId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentCicloId = null;
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Auto-submit del formulario de filtros cuando cambia el ordenamiento
document.getElementById('sort').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection
