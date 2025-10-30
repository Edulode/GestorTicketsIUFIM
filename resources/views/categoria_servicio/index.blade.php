@extends('layouts.authenticated')

@section('title', 'Gestión de Categorías de Servicio')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Categorías de Servicio</h1>
                <p class="mt-2 text-sm text-gray-600">Gestiona las categorías de servicio disponibles para clasificar los tickets</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('categorias-servicio.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Nueva Categoría
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
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <!-- Total Categorías -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-folder-open text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Categorías</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categorias->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categorías con Tipos de Solicitud -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-link text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Con Tipos Asociados</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categorias->filter(function($cat) { return $cat->tiposSolicitud->count() > 0; })->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categorías Más Utilizadas -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tickets Totales</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categorias->sum(function($cat) { return $cat->tickets->count(); }) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Tabla de Categorías -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-list mr-2"></i>
                    Lista de Categorías de Servicio
                </h3>
                @if(request()->hasAny(['search', 'sort']))
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-filter mr-1"></i>
                        Mostrando {{ $categorias->count() }} resultado(s) filtrado(s)
                    </div>
                @endif
            </div>
        </div>
        
        @if($categorias->count() > 0)
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
                                    <span>Categoría de Servicio</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipos de Solicitud
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tickets Asociados
                            </th>
                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categorias as $categoria)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $categoria->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-folder-open text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $categoria->categoria_servicio }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($categoria->tiposSolicitud->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-link mr-1"></i>
                                                {{ $categoria->tiposSolicitud->count() }} tipo(s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-unlink mr-1"></i>
                                                Sin tipos
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($categoria->tickets->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                {{ $categoria->tickets->count() }} ticket(s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-inbox mr-1"></i>
                                                Sin tickets
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <!-- Ver -->
                                        <a href="{{ route('categorias-servicio.show', $categoria->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Editar -->
                                        <a href="{{ route('categorias-servicio.edit', $categoria->id) }}" 
                                           class="text-green-600 hover:text-green-900 transition-colors duration-200" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Eliminar -->
                                        @if($categoria->tickets->count() == 0 && $categoria->tiposSolicitud->count() == 0)
                                            <form action="{{ route('categorias-servicio.destroy', $categoria->id) }}" 
                                                  method="POST" 
                                                  class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="text-red-600 hover:text-red-900 transition-colors duration-200 delete-button" 
                                                        title="Eliminar"
                                                        data-categoria="{{ $categoria->categoria_servicio }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed" 
                                                  title="No se puede eliminar: tiene tickets o tipos de solicitud asociados">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación si implementas paginación -->
            {{-- @if($categorias instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $categorias->links() }}
                </div>
            @endif --}}
            
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    @if(request()->hasAny(['search', 'sort']))
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    @else
                        <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                    @endif
                </div>
                @if(request()->hasAny(['search', 'sort']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron categorías</h3>
                    <p class="text-gray-500 mb-6">No hay categorías que coincidan con los filtros aplicados. Intenta ajustar los criterios de búsqueda.</p>
                    <a href="{{ route('categorias-servicio.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar Filtros
                    </a>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay categorías de servicio</h3>
                    <p class="text-gray-500 mb-6">Aún no has creado ninguna categoría de servicio. ¡Crea la primera para comenzar!</p>
                    <a href="{{ route('categorias-servicio.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Primera Categoría
                    </a>
                @endif
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
                <p class="mb-2">Está a punto de eliminar la categoría:</p>
                <p class="font-semibold text-gray-900" id="categoryToDelete"></p>
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
    const categoryToDelete = document.getElementById('categoryToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    let currentForm = null;
    
    // Abrir modal de confirmación
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            const categoria = this.getAttribute('data-categoria');
            currentForm = this.closest('.delete-form');
            
            categoryToDelete.textContent = categoria;
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
    
    // Auto-submit del formulario de filtros cuando cambie el select de ordenamiento
    const sortSelect = document.getElementById('sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    }
    
    // Búsqueda con delay para evitar múltiples requests
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length > 2 || this.value.length === 0) {
                    document.getElementById('filter-form').submit();
                }
            }, 500);
        });
    }
    
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