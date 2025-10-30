@extends('layouts.authenticated')

@section('title', 'Detalles del Área')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $area->area }}</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa del área organizacional</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('areas.edit', $area->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Área
                </a>
                <a href="{{ route('areas.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal del Área -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Básica -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-building mr-2"></i>
                        Información del Área
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre del Área</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $area->area }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID del Área</dt>
                            <dd class="mt-1 text-sm text-gray-900">#{{ $area->id }}</dd>
                        </div>
                        @if($area->descripcion)
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $area->descripcion }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Creación</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $area->created_at ? $area->created_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $area->updated_at ? $area->updated_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios del Área -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-users mr-2"></i>
                            Usuarios Asignados ({{ $area->usuarios->count() }})
                        </h3>
                        <a href="{{ route('usuarios.create') }}?area={{ $area->id }}" 
                           class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            Agregar Usuario
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($usuariosRecientes->count() > 0)
                        <div class="space-y-4">
                            @foreach($usuariosRecientes as $usuario)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <i class="fas fa-user text-blue-600"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">
                                                        {{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}
                                                    </h4>
                                                    <p class="text-sm text-gray-600">ID: #{{ $usuario->id }}</p>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex items-center text-xs text-gray-500 space-x-4">
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    Registrado: {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'No disponible' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-toggle-{{ $usuario->status ? 'on' : 'off' }} mr-1"></i>
                                                    {{ $usuario->status ? 'Activo' : 'Inactivo' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-ticket-alt mr-1"></i>
                                                    {{ $usuario->tickets->count() }} tickets
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('usuarios.show', $usuario->id) }}" 
                                               class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-eye mr-1"></i>
                                                Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if($area->usuarios->count() > 5)
                                <div class="text-center py-4">
                                    <a href="{{ route('usuarios.index') }}?area={{ $area->id }}" 
                                       class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                        Ver todos los usuarios ({{ $area->usuarios->count() }})
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No hay usuarios asignados a esta área.</p>
                            <div class="mt-4">
                                <a href="{{ route('usuarios.create') }}?area={{ $area->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Agregar Primer Usuario
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Subáreas -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-layer-group mr-2"></i>
                            Subáreas ({{ $area->subareas->count() }})
                        </h3>
                        <a href="{{ route('subareas.create') }}?area={{ $area->id }}" 
                           class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            Crear Subárea
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($area->subareas->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($area->subareas as $subarea)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $subarea->subarea }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $subarea->created_at ? $subarea->created_at->format('d/m/Y') : 'No disponible' }}
                                            </p>
                                        </div>
                                        <a href="{{ route('subareas.show', $subarea->id) }}" 
                                           class="text-blue-600 hover:text-blue-500">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fas fa-layer-group text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No hay subáreas creadas para esta área.</p>
                            <div class="mt-4">
                                <a href="{{ route('subareas.create') }}?area={{ $area->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Crear Primera Subárea
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tickets Recientes del Área -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets Recientes ({{ $ticketsRecientes->count() }})
                        </h3>
                        <a href="{{ route('tickets.index') }}?area={{ $area->id }}" 
                           class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                            Ver todos los tickets
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($ticketsRecientes->count() > 0)
                        <div class="space-y-4">
                            @foreach($ticketsRecientes as $ticket)
                                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    #{{ $ticket->id }} - {{ $ticket->asunto->asunto ?? 'Sin asunto' }}
                                                </h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ ($ticket->status && $ticket->status->status == 'Abierto') ? 'bg-green-100 text-green-800' : 
                                                       (($ticket->status && $ticket->status->status == 'En proceso') ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800') }}">
                                                    {{ $ticket->status->status ?? 'Sin estado' }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">{{ Str::limit($ticket->solicitud ?? 'Sin descripción', 100) }}</p>
                                            <div class="mt-2 flex items-center text-xs text-gray-500 space-x-4">
                                                <span>
                                                    <i class="fas fa-user mr-1"></i>
                                                    {{ $ticket->usuario ? ($ticket->usuario->nombre . ' ' . $ticket->usuario->apellido_paterno) : 'Usuario desconocido' }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                                </span>
                                                @if($ticket->tipo)
                                                <span>
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $ticket->tipo->tipo }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" 
                                               class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <i class="fas fa-eye mr-1"></i>
                                                Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No hay tickets registrados para esta área.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral de Estadísticas -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Estadísticas Generales -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas del Área
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total de Usuarios</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $area->usuarios->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Subáreas</span>
                            <span class="text-lg font-semibold text-green-600">{{ $area->subareas->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total de Tickets</span>
                            <span class="text-lg font-semibold text-purple-600">{{ $ticketsRecientes->count() }}</span>
                        </div>
                        @if($area->usuarios->count() > 0)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Promedio Tickets/Usuario</span>
                            <span class="text-lg font-semibold text-orange-600">
                                {{ round($ticketsRecientes->count() / $area->usuarios->count(), 1) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-bolt mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('usuarios.create') }}?area={{ $area->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-user-plus mr-2"></i>
                            Agregar Usuario
                        </a>
                        <a href="{{ route('subareas.create') }}?area={{ $area->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-layer-group mr-2"></i>
                            Crear Subárea
                        </a>
                        <a href="{{ route('areas.edit', $area->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Información
                        </a>
                        <button type="button" onclick="confirmarEliminacion()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Área
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div id="modal-eliminar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">¿Eliminar Área?</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Esta acción no se puede deshacer. Se eliminará permanentemente el área 
                    <strong>{{ $area->area }}</strong> y todos sus datos asociados.
                </p>
                @if($area->usuarios->count() > 0 || $area->subareas->count() > 0)
                    <p class="mt-2 text-sm text-red-600 font-medium">
                        ⚠️ Esta área tiene {{ $area->usuarios->count() }} usuario(s) y {{ $area->subareas->count() }} subárea(s) asignadas.
                    </p>
                @endif
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="{{ route('areas.destroy', $area->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Eliminar
                    </button>
                </form>
                <button onclick="cerrarModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion() {
    document.getElementById('modal-eliminar').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modal-eliminar').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modal-eliminar').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
@endsection
