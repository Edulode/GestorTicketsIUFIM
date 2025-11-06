@extends('layouts.authenticated')

@section('title', 'Tickets de TI')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tickets</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('tickets.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Ticket
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
    <div class="flex flex-wrap justify-center gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg w-full sm:w-64">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate text-center">Total Tickets</dt>
                            <dd class="text-lg font-medium text-gray-900 text-center">{{ $totalTickets }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg w-full sm:w-64">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate text-center">Pendientes</dt>
                            <dd class="text-lg font-medium text-gray-900 text-center">{{ $pendientesCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg w-full sm:w-64">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-check-circle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate text-center">Resueltos</dt>
                            <dd class="text-lg font-medium text-gray-900 text-center">{{ $resueltosCount }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-filter mr-2"></i>
                Filtros
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('tickets.index') }}" id="filter-form">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select id="status-filter" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Resuelto" {{ request('status') == 'Resuelto' ? 'selected' : '' }}>Resuelto</option>
                        </select>
                    </div>
                    <div>
                        <label for="area-filter" class="block text-sm font-medium text-gray-700">Área</label>
                        <select id="area-filter" name="area" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Todas las áreas</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date-filter" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" id="date-filter" name="date" value="{{ request('date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Buscar tickets..." class="block w-full pl-10 pr-3 py-2 border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <a href="{{ route('tickets.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" title="Limpiar filtros">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-list mr-2"></i>
                    Lista de Tickets
                </h3>
                @if(request()->hasAny(['status', 'area', 'date', 'search']))
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-filter mr-1"></i>
                        Mostrando {{ $tickets->count() }} resultado(s) filtrado(s)
                        @if(request('search'))
                            para "{{ request('search') }}"
                        @endif
                    </div>
                @endif
            </div>
        </div>
        
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Ticket</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Área</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Usuario</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center space-x-1">
                                    <span>Fecha</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
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
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-1 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600">#{{ $ticket->id }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-1 py-4">
                                    
                                    <div class="text-sm text-gray-500">{{ $ticket->area->area }}</div>
                                </td>
                                <td class="px-1 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $ticket->usuario->nombre . " " . $ticket->usuario->apellido_paterno . " " . $ticket->usuario->apellido_materno }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($ticket->solicitud, 60) }}</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $ticket->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
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
                                <td class="px-8 py-4 whitespace-nowrap text-lg font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-green-600 hover:text-green-900 transition-colors duration-200" title="Editar">
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
                        Mostrando <span class="font-medium">{{ $tickets->firstItem() ?? 0 }}</span> a <span class="font-medium">{{ $tickets->lastItem() ?? 0 }}</span> de <span class="font-medium">{{ $tickets->total() }}</span> tickets
                    </div>
                    <div>
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    @if(request()->hasAny(['status', 'area', 'date', 'search']))
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    @else
                        <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                    @endif
                </div>
                @if(request()->hasAny(['status', 'area', 'date', 'search']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No se encontraron tickets</h3>
                    <p class="text-gray-500 mb-6">No hay tickets que coincidan con los filtros aplicados. Intenta ajustar los criterios de búsqueda.</p>
                    <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition">
                        <i class="fas fa-times mr-2"></i>
                        Limpiar Filtros
                    </a>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tickets disponibles</h3>
                    <p class="text-gray-500 mb-6">Aún no has creado ningún ticket de soporte. ¡Crea tu primer ticket para comenzar!</p>
                    <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Crear Primer Ticket
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Script para funcionalidades de filtros con AJAX y auto-actualización -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('status-filter');
    const areaFilter = document.getElementById('area-filter');
    const dateFilter = document.getElementById('date-filter');
    
    let autoRefreshInterval;
    let isFiltering = false;
    
    // Función para cargar tickets via AJAX
    function loadTickets(showLoading = false) {
        if (isFiltering) return; // Evitar múltiples peticiones simultáneas
        
        isFiltering = true;
        
        if (showLoading) {
            showLoadingIndicator();
        }
        
        // Obtener parámetros actuales
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        fetch(`{{ route('api.tickets') }}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            updateTicketsTable(data.tickets);
            updateStatsCards(data);
            updateFilterResults(data.total);
            if (showLoading) hideLoadingIndicator();
            isFiltering = false;
        })
        .catch(error => {
            console.error('Error al cargar tickets:', error);
            if (showLoading) hideLoadingIndicator();
            isFiltering = false;
        });
    }
    
    // Función para mostrar indicador de carga
    function showLoadingIndicator() {
        const tableContainer = document.querySelector('.overflow-x-auto');
        if (tableContainer) {
            tableContainer.style.opacity = '0.6';
            tableContainer.style.pointerEvents = 'none';
        }
    }
    
    // Función para ocultar indicador de carga
    function hideLoadingIndicator() {
        const tableContainer = document.querySelector('.overflow-x-auto');
        if (tableContainer) {
            tableContainer.style.opacity = '1';
            tableContainer.style.pointerEvents = 'auto';
        }
    }
    
    // Función para actualizar la tabla de tickets
    function updateTicketsTable(tickets) {
        const tbody = document.querySelector('tbody');
        const emptyState = document.querySelector('.text-center.py-12');
        const tableContainer = document.querySelector('.overflow-x-auto');
        
        if (tickets.length === 0) {
            if (tableContainer) tableContainer.style.display = 'none';
            if (emptyState) emptyState.style.display = 'block';
            return;
        }
        
        if (tableContainer) tableContainer.style.display = 'block';
        if (emptyState) emptyState.style.display = 'none';
        
        if (!tbody) return;
        
        tbody.innerHTML = tickets.map(ticket => `
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-1 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">#${ticket.id}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-1 py-4">
                    <div class="text-sm text-gray-500">${ticket.area_nombre}</div>
                </td>
                <td class="px-1 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${ticket.usuario_nombre}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-900">${ticket.solicitud.length > 60 ? ticket.solicitud.substring(0, 60) + '...' : ticket.solicitud}</div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${ticket.fecha}</div>
                    <div class="text-sm text-gray-500">${ticket.hora}</div>
                </td>
                <td class="px-3 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${ticket.status_color}">
                        <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                        ${ticket.status}
                    </span>
                </td>
                <td class="px-8 py-4 whitespace-nowrap text-lg font-medium">
                    <div class="flex space-x-3">
                        <a href="${ticket.show_url}" class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="${ticket.edit_url}" class="text-green-600 hover:text-green-900 transition-colors duration-200" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `).join('');
    }
    
    // Función para actualizar las tarjetas de estadísticas
    function updateStatsCards(data) {
        const totalCard = document.querySelector('.bg-blue-500').closest('.p-5').querySelector('dd');
        const pendientesCard = document.querySelector('.bg-yellow-500').closest('.p-5').querySelector('dd');
        const completadosCard = document.querySelector('.bg-green-500').closest('.p-5').querySelector('dd');
        
        if (totalCard) totalCard.textContent = data.total;
        if (pendientesCard) pendientesCard.textContent = data.pendientes;
        if (completadosCard) completadosCard.textContent = data.completados;
    }
    
    // Función para actualizar el contador de resultados filtrados
    function updateFilterResults(total) {
        const filterInfo = document.querySelector('.text-sm.text-gray-600');
        if (filterInfo) {
            const hasFilters = searchInput.value || statusFilter.value || areaFilter.value || dateFilter.value;
            if (hasFilters) {
                filterInfo.innerHTML = `<i class="fas fa-filter mr-1"></i>Mostrando ${total} resultado(s) filtrado(s)${searchInput.value ? ' para "' + searchInput.value + '"' : ''}`;
            }
        }
    }
    
    // Función para aplicar filtros (reemplaza el submit del formulario)
    function applyFilters() {
        // Actualizar URL sin recargar la página
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        const newUrl = params.toString() ? 
            '{{ route("tickets.index") }}?' + params.toString() : 
            '{{ route("tickets.index") }}';
        
        window.history.pushState({}, '', newUrl);
        
        // Cargar tickets con AJAX
        loadTickets(true);
        updateFilterIndicator();
    }
    
    // Eventos para auto-aplicar filtros
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    
    if (areaFilter) {
        areaFilter.addEventListener('change', applyFilters);
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', applyFilters);
    }
    
    // Búsqueda con delay
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilters, 800);
        });
    }
    
    // Prevenir el submit normal del formulario
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });
    
    // Auto-actualización cada 30 segundos (solo si no hay filtros activos)
    function startAutoRefresh() {
        autoRefreshInterval = setInterval(() => {
            const hasFilters = searchInput.value || statusFilter.value || areaFilter.value || dateFilter.value;
            if (!hasFilters && !isFiltering) {
                loadTickets(false); // Sin indicador de carga para auto-refresh
            }
        }, 30000); // 30 segundos
    }
    
    // Detener auto-actualización
    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    }
    
    // Iniciar auto-actualización
    startAutoRefresh();
    
    // Detener auto-actualización cuando el usuario está filtrando
    [statusFilter, areaFilter, dateFilter, searchInput].forEach(element => {
        if (element) {
            element.addEventListener('focus', stopAutoRefresh);
            element.addEventListener('blur', () => {
                setTimeout(startAutoRefresh, 5000); // Reiniciar después de 5 segundos
            });
        }
    });
    
    // Indicador visual de filtros activos
    function updateFilterIndicator() {
        const hasFilters = searchInput.value || statusFilter.value || areaFilter.value || dateFilter.value;
        const filterTitle = document.querySelector('.px-6.py-4 h3');
        
        if (hasFilters) {
            if (!filterTitle.querySelector('.filter-active-indicator')) {
                const indicator = document.createElement('span');
                indicator.className = 'filter-active-indicator inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2';
                indicator.innerHTML = '<i class="fas fa-circle mr-1" style="font-size: 6px;"></i>Activos';
                filterTitle.appendChild(indicator);
            }
        } else {
            const indicator = filterTitle.querySelector('.filter-active-indicator');
            if (indicator) {
                indicator.remove();
            }
        }
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
    
    // Actualizar indicador al cargar la página
    updateFilterIndicator();
    
    // Agregar indicador visual de última actualización
    function addLastUpdateIndicator() {
        const header = document.querySelector('.sm\\:flex.sm\\:items-center.sm\\:justify-between.mb-8');
        if (header && !header.querySelector('.last-update')) {
            const lastUpdate = document.createElement('div');
            lastUpdate.className = 'last-update text-xs text-gray-500 mt-2';
            lastUpdate.innerHTML = '<i class="fas fa-sync-alt mr-1"></i>Actualizado: ' + new Date().toLocaleTimeString();
            header.querySelector('div:first-child').appendChild(lastUpdate);
        }
    }
    
    // Actualizar indicador de tiempo
    function updateLastUpdateIndicator() {
        const lastUpdate = document.querySelector('.last-update');
        if (lastUpdate) {
            lastUpdate.innerHTML = '<i class="fas fa-sync-alt mr-1"></i>Actualizado: ' + new Date().toLocaleTimeString();
        }
    }
    
    // Agregar indicador al cargar
    addLastUpdateIndicator();
    
    // Actualizar indicador después de cada carga AJAX
    const originalLoadTickets = loadTickets;
    loadTickets = function(...args) {
        originalLoadTickets.apply(this, args);
        setTimeout(updateLastUpdateIndicator, 500);
    };
});
</script>
@endsection