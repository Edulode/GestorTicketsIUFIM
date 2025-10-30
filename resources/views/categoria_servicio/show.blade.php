@extends('layouts.authenticated')

@section('title', 'Detalles de Categoría de Servicio')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('categorias-servicio.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $categoria->categoria_servicio }}</h1>
                    <p class="mt-2 text-sm text-gray-600">Detalles y estadísticas de la categoría de servicio</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('categorias-servicio.edit', $categoria->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
                    <i class="fas fa-edit mr-2"></i>
                    Editar
                </a>
            </div>
        </div>
    </div>

    <!-- Información Principal -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-info-circle mr-2"></i>
                Información General
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-500">ID</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">#{{ $categoria->id }}</p>
                </div>
                
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-medium text-gray-500">Nombre de Categoría</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $categoria->categoria_servicio }}</p>
                </div>
                
                <!-- Fecha de Creación -->
                <div>
                    <label class="block text-sm font-medium text-gray-500">Fecha de Creación</label>
                    @if($categoria->created_at)
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $categoria->created_at->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $categoria->created_at->format('H:i') }}</p>
                    @else
                        <p class="mt-1 text-lg font-semibold text-gray-500">No disponible</p>
                    @endif
                </div>
                
                <!-- Última Actualización -->
                <div>
                    <label class="block text-sm font-medium text-gray-500">Última Actualización</label>
                    @if($categoria->updated_at)
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $categoria->updated_at->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $categoria->updated_at->format('H:i') }}</p>
                    @else
                        <p class="mt-1 text-lg font-semibold text-gray-500">No disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Tipos de Solicitud -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-tag text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tipos de Solicitud</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $categoria->tiposSolicitud->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tickets -->
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
                            <dd class="text-lg font-medium text-gray-900">{{ $categoria->tickets->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Resueltos -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-check-circle text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tickets Resueltos</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                {{ $categoria->tickets->where('status.status', 'Resuelto')->count() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Porcentaje de Resolución -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-chart-pie text-white text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">% Resolución</dt>
                            <dd class="text-lg font-medium text-gray-900">
                                @if($categoria->tickets->count() > 0)
                                    {{ round(($categoria->tickets->where('status.status', 'Resuelto')->count() / $categoria->tickets->count()) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tipos de Solicitud Asociados -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-link mr-2"></i>
                    Tipos de Solicitud Asociados ({{ $categoria->tiposSolicitud->count() }})
                </h3>
                @if($categoria->tiposSolicitud->count() > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ $categoria->tiposSolicitud->count() }} tipo(s) asociado(s)
                    </span>
                @endif
            </div>
        </div>
        
        @if($categoria->tiposSolicitud->count() > 0)
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categoria->tiposSolicitud as $tipo)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $tipo->tipo_solicitud }}</p>
                                    <p class="text-xs text-gray-500">ID: #{{ $tipo->id }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $tipo->tickets->count() }} ticket(s)
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-unlink text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Sin tipos de solicitud asociados</h3>
                <p class="text-gray-500">Esta categoría aún no tiene tipos de solicitud vinculados.</p>
            </div>
        @endif
    </div>

    <!-- Tickets Recientes -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-clock mr-2"></i>
                    Tickets Recientes (Últimos 10)
                </h3>
                @if($categoria->tickets->count() > 0)
                    <a href="{{ route('tickets.index', ['categoria_servicio_id' => $categoria->id]) }}" 
                       class="text-sm text-blue-600 hover:text-blue-500">
                        Ver todos los tickets →
                    </a>
                @endif
            </div>
        </div>
        
        @if($categoria->tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categoria->tickets->sortByDesc('created_at')->take(10) as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $ticket->id }}</div>
                                    <div class="text-sm text-gray-500 truncate max-w-xs">{{ $ticket->asunto }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $ticket->usuario->nombre ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $ticket->usuario->correo ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $ticket->tipoSolicitud->tipo_solicitud ?? 'Sin tipo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($ticket->status->status == 'Resuelto') bg-green-100 text-green-800
                                            @elseif($ticket->status->status == 'En Proceso') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->status->status == 'Pendiente') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $ticket->status->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Sin estado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($ticket->created_at)
                                        <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs">{{ $ticket->created_at->format('H:i') }}</div>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Sin tickets</h3>
                <p class="text-gray-500">Esta categoría aún no tiene tickets asociados.</p>
            </div>
        @endif
    </div>
</div>
@endsection
