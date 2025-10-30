@extends('layouts.authenticated')

@section('title', 'Reportes y Análisis')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Reportes y Análisis de Tickets</h1>
                <p class="mt-2 text-sm text-gray-700">Análisis dinámico y estadísticas del sistema de tickets</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Panel
                </a>
                <button id="btn-exportar" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-download mr-2"></i>
                    Exportar Reporte
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros de Fecha y Ciclo -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-filter mr-2"></i>
                Filtros para Análisis Dinámico
            </h3>
        </div>
        <div class="p-6">
            <form id="filtros-form" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" 
                           value="{{ now()->startOfMonth()->format('Y-m-d') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" 
                           value="{{ now()->format('Y-m-d') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="ciclo_id" class="block text-sm font-medium text-gray-700">Ciclo</label>
                    <select id="ciclo_id" name="ciclo_id" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Todos los ciclos</option>
                        @foreach($ciclos as $ciclo)
                            <option value="{{ $ciclo->id }}">{{ $ciclo->ciclo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Generar Análisis
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loading" class="hidden text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600">Generando reporte...</p>
    </div>

    <!-- Estadísticas Generales -->
    <div id="estadisticas-generales" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" style="display: none;">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Tickets</dt>
                            <dd id="total-tickets" class="text-lg font-medium text-gray-900">0</dd>
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
                            <i class="fas fa-check-circle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Resueltos</dt>
                            <dd id="tickets-completados" class="text-lg font-medium text-gray-900">0</dd>
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
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                            <dd id="tickets-pendientes" class="text-lg font-medium text-gray-900">0</dd>
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
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tiempo Promedio de Resolución</dt>
                            <dd id="tiempo-promedio" class="text-lg font-medium text-gray-900">0h</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficas Dinámicas -->
    <div id="graficas-dinamicas" class="border-2 border-blue-200 rounded-xl shadow-lg bg-white mb-12" style="display: none;">
        <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-8 rounded-t-xl border-b-2 border-blue-200">
            <h2 class="text-3xl font-bold text-blue-900 mb-3">
                <i class="fas fa-chart-line mr-3 text-blue-600 bg-white p-2 rounded-full shadow"></i>
                Análisis Dinámico por Período Seleccionado
            </h2>
        </div>
        
        <div class="p-6 bg-blue-50/30">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Tickets por Área -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tickets por Área Solicitante</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-areas" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Tickets por Tipo -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Top 5 - Tickets por Tipo de Solicitud</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-tipos" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Categorías de Servicio -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Top 5 - Tickets por Categoría de Servicio (Solo Resueltos)</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-status" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Tickets por Lugar -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Top 7 - Tickets por Lugar de Incidencia</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-lugares" width="400" height="300"></canvas>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Gráficas Fijas -->
    <div class="border-2 border-green-200 rounded-xl shadow-lg bg-white mb-12">
        <div class="bg-gradient-to-r from-green-100 to-emerald-100 p-8 rounded-t-xl border-b-2 border-green-200">
            <h2 class="text-3xl font-bold text-green-900 mb-3">
                <i class="fas fa-chart-bar mr-3 text-green-600 bg-white p-2 rounded-full shadow"></i>
                Análisis General del Sistema
            </h2>
        </div>
        
        <div class="p-6 bg-green-50/30">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Áreas que más solicitan -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Áreas que Más Solicitan (Top 10)</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-areas-fijo" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Lugares con más incidencias -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Lugares con Más Incidencias (Top 10)</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-lugares-fijo" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Tipos de Solicitud más comunes -->
            <div class="bg-white shadow rounded-lg lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tipos de Solicitud Más Comunes (Top 10)</h3>
                </div>
                <div class="p-6">
                    <canvas id="chart-incidencias-fijo" width="800" height="300"></canvas>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Tickets Pendientes -->
    <div class="border-2 border-yellow-200 rounded-xl shadow-lg bg-white">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-100 to-amber-100 rounded-t-xl border-b-2 border-yellow-200">
            <h3 class="text-xl font-bold text-yellow-900">
                <i class="fas fa-exclamation-triangle mr-2 text-yellow-600 bg-white p-1 rounded-full shadow"></i>
                Tickets Pendientes de Resolución
            </h3>
        </div>
        <div class="p-6 bg-yellow-50/20">
            <div id="tickets-pendientes-container">
                <p class="text-gray-500 text-center py-4">Cargando tickets pendientes...</p>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let charts = {};

document.addEventListener('DOMContentLoaded', function() {
    // Cargar datos iniciales
    cargarDatos();
    
    // Event listener para el formulario
    document.getElementById('filtros-form').addEventListener('submit', function(e) {
        e.preventDefault();
        cargarDatos();
    });
    
    // Event listener para exportar
    document.getElementById('btn-exportar').addEventListener('click', exportarDatos);
});

function cargarDatos() {
    const formData = new FormData(document.getElementById('filtros-form'));
    const params = new URLSearchParams(formData);
    
    document.getElementById('loading').classList.remove('hidden');
    
    fetch(`/reportes/datos?${params}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            actualizarEstadisticas(data.estadisticas);
            actualizarGraficasDinamicas(data.dinamicas);
            actualizarGraficasFijas(data.fijas);
            actualizarTicketsPendientes(data.fijas.tickets_pendientes);
            
            document.getElementById('estadisticas-generales').style.display = 'grid';
            document.getElementById('graficas-dinamicas').style.display = 'block';
            document.getElementById('loading').classList.add('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loading').classList.add('hidden');
            alert('Error al cargar los datos: ' + error.message);
        });
}

function actualizarEstadisticas(stats) {
    document.getElementById('total-tickets').textContent = stats.total_tickets;
    document.getElementById('tickets-completados').textContent = stats.tickets_completados;
    document.getElementById('tickets-pendientes').textContent = stats.tickets_pendientes;
    document.getElementById('tiempo-promedio').textContent = stats.tiempo_promedio_resolucion + 'h';
}

function actualizarGraficasDinamicas(data) {
    // Gráfica de Áreas
    actualizarGrafica('chart-areas', {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.areas),
            datasets: [{
                data: Object.values(data.areas),
                backgroundColor: [
                    '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
                    '#06B6D4', '#F97316', '#84CC16', '#EC4899', '#6B7280'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Gráfica de Tipos
    actualizarGrafica('chart-tipos', {
        type: 'bar',
        data: {
            labels: Object.keys(data.tipos),
            datasets: [{
                label: 'Cantidad de Tickets',
                data: Object.values(data.tipos),
                backgroundColor: [
                    '#3B82F6', // Azul
                    '#10B981', // Verde
                    '#F59E0B', // Amarillo
                    '#EF4444', // Rojo
                    '#8B5CF6'  // Púrpura
                ],
                borderColor: [
                    '#2563EB', // Azul oscuro
                    '#059669', // Verde oscuro
                    '#D97706', // Amarillo oscuro
                    '#DC2626', // Rojo oscuro
                    '#7C3AED'  // Púrpura oscuro
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Gráfica de Lugares
    actualizarGrafica('chart-lugares', {
        type: 'bar',
        data: {
            labels: Object.keys(data.lugares),
            datasets: [{
                label: 'Incidencias',
                data: Object.values(data.lugares),
                backgroundColor: [
                    '#10B981', // Verde
                    '#3B82F6', // Azul
                    '#F59E0B', // Amarillo
                    '#EF4444', // Rojo
                    '#8B5CF6', // Púrpura
                    '#06B6D4', // Cyan
                    '#F97316'  // Naranja
                ],
                borderColor: [
                    '#059669', // Verde oscuro
                    '#2563EB', // Azul oscuro
                    '#D97706', // Amarillo oscuro
                    '#DC2626', // Rojo oscuro
                    '#7C3AED', // Púrpura oscuro
                    '#0891B2', // Cyan oscuro
                    '#EA580C'  // Naranja oscuro
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Gráfica de Categorías de Servicio
    actualizarGrafica('chart-status', {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.categorias),
            datasets: [{
                label: 'Tickets',
                data: Object.values(data.categorias),
                backgroundColor: [
                    '#10B981', // Verde
                    '#3B82F6', // Azul
                    '#F59E0B', // Amarillo
                    '#EF4444', // Rojo
                    '#8B5CF6', // Púrpura
                    '#06B6D4', // Cyan
                    '#F97316'  // Naranja
                ],
                borderColor: [
                    '#059669', // Verde oscuro
                    '#2563EB', // Azul oscuro
                    '#D97706', // Amarillo oscuro
                    '#DC2626', // Rojo oscuro
                    '#7C3AED', // Púrpura oscuro
                    '#0891B2', // Cyan oscuro
                    '#EA580C'  // Naranja oscuro
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

function actualizarGraficasFijas(data) {
    // Áreas que más solicitan
    actualizarGrafica('chart-areas-fijo', {
        type: 'bar',
        data: {
            labels: Object.keys(data.areas_mas_solicitan),
            datasets: [{
                label: 'Total de Tickets',
                data: Object.values(data.areas_mas_solicitan),
                backgroundColor: [
                    '#8B5CF6', // Púrpura
                    '#3B82F6', // Azul
                    '#10B981', // Verde
                    '#F59E0B', // Amarillo
                    '#EF4444', // Rojo
                    '#06B6D4', // Cyan
                    '#F97316', // Naranja
                    '#84CC16', // Lima
                    '#EC4899', // Rosa
                    '#6B7280'  // Gris
                ],
                borderColor: [
                    '#7C3AED', // Púrpura oscuro
                    '#2563EB', // Azul oscuro
                    '#059669', // Verde oscuro
                    '#D97706', // Amarillo oscuro
                    '#DC2626', // Rojo oscuro
                    '#0891B2', // Cyan oscuro
                    '#EA580C', // Naranja oscuro
                    '#65A30D', // Lima oscuro
                    '#DB2777', // Rosa oscuro
                    '#4B5563'  // Gris oscuro
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Lugares con más incidencias
    actualizarGrafica('chart-lugares-fijo', {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.lugares_mas_incidencias),
            datasets: [{
                data: Object.values(data.lugares_mas_incidencias),
                backgroundColor: [
                    '#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6',
                    '#06B6D4', '#F97316', '#84CC16', '#EC4899', '#6B7280'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
    
    // Tipos de Solicitud más comunes
    actualizarGrafica('chart-incidencias-fijo', {
        type: 'bar',
        data: {
            labels: Object.keys(data.tipos_solicitud_comunes),
            datasets: [{
                label: 'Frecuencia',
                data: Object.values(data.tipos_solicitud_comunes),
                backgroundColor: [
                    '#3B82F6', // Azul
                    '#10B981', // Verde
                    '#F59E0B', // Amarillo
                    '#EF4444', // Rojo
                    '#8B5CF6', // Púrpura
                    '#06B6D4', // Cyan
                    '#F97316', // Naranja
                    '#84CC16', // Lima
                    '#EC4899', // Rosa
                    '#6B7280'  // Gris
                ],
                borderColor: [
                    '#2563EB', // Azul oscuro
                    '#059669', // Verde oscuro
                    '#D97706', // Amarillo oscuro
                    '#DC2626', // Rojo oscuro
                    '#7C3AED', // Púrpura oscuro
                    '#0891B2', // Cyan oscuro
                    '#EA580C', // Naranja oscuro
                    '#65A30D', // Lima oscuro
                    '#DB2777', // Rosa oscuro
                    '#4B5563'  // Gris oscuro
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function actualizarGrafica(canvasId, config) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    
    // Destruir gráfica anterior si existe
    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }
    
    charts[canvasId] = new Chart(ctx, config);
}

function actualizarTicketsPendientes(ticketsPendientes) {
    const container = document.getElementById('tickets-pendientes-container');
    
    if (ticketsPendientes.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-center py-4">No hay tickets pendientes.</p>';
        return;
    }
    
    let html = `
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Días Pendiente</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    `;
    
    ticketsPendientes.forEach(ticket => {
        const diasRedondeados = Math.round(ticket.dias_pendiente);
        const urgencia = diasRedondeados > 7 ? 'text-red-600' : diasRedondeados > 3 ? 'text-yellow-600' : 'text-green-600';
        const statusClass = ticket.status === 'Resuelto' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
        
        html += `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#${ticket.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${ticket.asunto}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${ticket.area}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                        ${ticket.status}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${ticket.fecha_creacion}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${urgencia}">${diasRedondeados} días</td>
            </tr>
        `;
    });
    
    html += `
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = html;
}

function exportarDatos() {
    const formData = new FormData(document.getElementById('filtros-form'));
    const params = new URLSearchParams(formData);
    
    // Crear un enlace temporal para descargar
    const url = `/reportes/exportar?${params}`;
    const link = document.createElement('a');
    link.href = url;
    link.download = `reporte_tickets_${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection