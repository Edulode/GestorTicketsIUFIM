@extends('layouts.authenticated')

@section('title', 'Gestión de Tipos de Solicitud')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tipos de Solicitud</h1>
                <p class="mt-2 text-sm text-gray-700">Gestiona los tipos de solicitud para clasificar tickets</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Panel
                </a>
                <a href="{{ route('tipos_solicitud.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>
                    Nuevo Tipo
                </a>
            </div>
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
                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tipos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tiposSolicitud->count() }}</dd>
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
                            <i class="fas fa-ticket-alt text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tiposSolicitud->sum(function($tipo) { return $tipo->tickets->count(); }) }}</dd>
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
                            <i class="fas fa-folder-open text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Con Categoría</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tiposSolicitud->whereNotNull('categoria_servicio_id')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tipos Activos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $tiposSolicitud->filter(function($tipo) { return $tipo->tickets->count() > 0; })->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Tipos de Solicitud -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-list mr-2"></i>
                    Lista de Tipos de Solicitud
                </h3>
                <span class="text-sm text-gray-600">
                    {{ $tiposSolicitud->count() }} tipo(s) registrado(s)
                </span>
            </div>
        </div>

        @if($tiposSolicitud->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>ID</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Tipo de Solicitud</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Categoría de Servicio
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tickets Asociados
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tiposSolicitud as $tipo)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $tipo->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-clipboard-list text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $tipo->tipo_solicitud }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Creado: {{ $tipo->created_at ? $tipo->created_at->format('d/m/Y') : 'No disponible' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tipo->categoriaServicio)
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-folder-open mr-1"></i>
                                                {{ $tipo->categoriaServicio->categoria_servicio }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-minus mr-1"></i>
                                            Sin categoría
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($tipo->tickets->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                {{ $tipo->tickets->count() }} ticket(s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-inbox mr-1"></i>
                                                Sin tickets
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tipo->tickets->count() > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- Ver -->
                                        <a href="{{ route('tipos_solicitud.show', $tipo->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Editar -->
                                        <a href="{{ route('tipos_solicitud.edit', $tipo->id) }}" 
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
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tipos de solicitud</h3>
                <p class="text-gray-500 mb-6">Aún no has creado ningún tipo de solicitud. ¡Crea el primero para comenzar!</p>
                <a href="{{ route('tipos_solicitud.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Crear Primer Tipo
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Icono de advertencia -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            
            <!-- Título -->
            <h3 class="text-lg font-medium text-gray-900 text-center mb-2">
                Confirmar Eliminación
            </h3>
            
            <!-- Mensaje -->
            <div class="text-sm text-gray-500 text-center mb-6">
                <p class="mb-2">Está a punto de eliminar el tipo de solicitud:</p>
                <p class="font-semibold text-gray-900" id="tipoToDelete"></p>
                <p class="mt-2 text-red-600">⚠️ Esta acción es permanente e irreversible</p>
            </div>
            
            <!-- Botones -->
            <div class="flex justify-center space-x-3">
                <button type="button" 
                        id="cancelDelete"
                        class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button type="button" 
                        id="confirmDelete"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar Definitivamente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para funcionalidades adicionales -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables del modal
    const deleteModal = document.getElementById('deleteModal');
    const tipoToDelete = document.getElementById('tipoToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    let currentForm = null;
    
    // Abrir modal de confirmación
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const tipo = this.getAttribute('data-tipo');
            currentForm = this.closest('.delete-form');
            
            tipoToDelete.textContent = tipo;
            deleteModal.classList.remove('hidden');
            
            // Animación de entrada
            setTimeout(() => {
                deleteModal.querySelector('.relative').style.transform = 'scale(1)';
                deleteModal.querySelector('.relative').style.opacity = '1';
            }, 10);
        });
    });
    
    // Confirmar eliminación
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentForm) {
            // Cambiar a estado de carga
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Eliminando...';
            this.disabled = true;
            
            // Enviar formulario
            currentForm.submit();
        }
    });
    
    // Cancelar eliminación
    function closeModal() {
        deleteModal.querySelector('.relative').style.transform = 'scale(0.9)';
        deleteModal.querySelector('.relative').style.opacity = '0';
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            currentForm = null;
            confirmDeleteBtn.innerHTML = '<i class="fas fa-trash mr-2"></i>Eliminar Definitivamente';
            confirmDeleteBtn.disabled = false;
        }, 200);
    }
    
    cancelDeleteBtn.addEventListener('click', closeModal);
    
    // Cerrar modal al hacer clic fuera
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeModal();
        }
    });
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Estilo inicial del modal
    deleteModal.querySelector('.relative').style.transform = 'scale(0.9)';
    deleteModal.querySelector('.relative').style.opacity = '0';
    deleteModal.querySelector('.relative').style.transition = 'all 0.2s ease-out';
    
    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Tooltips para acciones deshabilitadas
    const disabledActions = document.querySelectorAll('.cursor-not-allowed');
    disabledActions.forEach(action => {
        action.addEventListener('mouseenter', function() {
            // Aquí puedes agregar lógica para mostrar tooltips más elaborados
        });
    });
});
</script>
@endsection