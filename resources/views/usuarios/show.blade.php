@extends('layouts.authenticated')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</h1>
                <p class="mt-2 text-sm text-gray-700">Información completa del usuario</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Usuario
                </a>
                <a href="{{ route('usuarios.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a la Lista
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal del Usuario -->
        <div class="lg:col-span-2">
            <!-- Información Personal -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-user mr-2"></i>
                        Información Personal
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Área</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $usuario->area->area ?? 'Sin área asignada' }}
                                </span>
                            </dd>
                        </div>
                        @if($usuario->email)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $usuario->email }}" class="text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-envelope mr-1"></i>
                                    {{ $usuario->email }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($usuario->telefono)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="tel:{{ $usuario->telefono }}" class="text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-phone mr-1"></i>
                                    {{ $usuario->telefono }}
                                </a>
                            </dd>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Sistema
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID de Usuario</dt>
                            <dd class="mt-1 text-sm text-gray-900">#{{ $usuario->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última Actualización</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'No disponible' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activo
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Recientes -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-ticket-alt mr-2"></i>
                            Tickets Recientes ({{ $ticketsRecientes->count() }})
                        </h3>
                        <a href="{{ route('tickets.index') }}?usuario={{ $usuario->id }}" 
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
                                                    {{ $ticket->status->status == 'Abierto' ? 'bg-green-100 text-green-800' : 
                                                       ($ticket->status->status == 'En proceso' ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800') }}">
                                                    {{ $ticket->status->status ?? 'Sin estado' }}
                                                </span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600">{{ $ticket->descripcion_problema ?? 'Sin descripción' }}</p>
                                            <div class="mt-2 flex items-center text-xs text-gray-500 space-x-4">
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'Fecha no disponible' }}
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
                            <p class="text-gray-500">Este usuario no ha creado ningún ticket aún.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Panel Lateral de Estadísticas -->
        <div class="lg:col-span-1">
            <!-- Estadísticas de Tickets -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Estadísticas de Tickets
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Total de Tickets</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $usuario->tickets->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Tickets Abiertos</span>
                            <span class="text-lg font-semibold text-green-600">
                                {{ $usuario->tickets->filter(function($ticket) {
                                    return $ticket->status && $ticket->status->status == 'Abierto';
                                })->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">En Proceso</span>
                            <span class="text-lg font-semibold text-yellow-600">
                                {{ $usuario->tickets->filter(function($ticket) {
                                    return $ticket->status && $ticket->status->status == 'En proceso';
                                })->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Completados</span>
                            <span class="text-lg font-semibold text-blue-600">
                                {{ $usuario->tickets->filter(function($ticket) {
                                    return $ticket->status && $ticket->status->status == 'Completado';
                                })->count() }}
                            </span>
                        </div>
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
                        <a href="{{ route('tickets.create') }}?usuario={{ $usuario->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-plus mr-2"></i>
                            Crear Ticket para este Usuario
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Información
                        </a>
                        <button type="button" onclick="confirmarEliminacion()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Usuario
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
            <h3 class="text-lg font-medium text-gray-900 mt-2">¿Eliminar Usuario?</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Esta acción no se puede deshacer. Se eliminará permanentemente el usuario 
                    <strong>{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</strong> 
                    y todos sus datos asociados.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}" class="inline">
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
