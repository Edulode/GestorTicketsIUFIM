@extends('layouts.authenticated')

@section('title', 'Dashboard de Administración')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard de Administración</h1>
                <p class="mt-2 text-sm text-gray-700">Estadísticas y métricas del sistema de tickets</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Tickets -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Tickets por Estado
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Pendientes</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $ticketsByStatus['pendientes'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Resueltos</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $ticketsByStatus['resueltos'] }}</span>
                    </div>
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Total</span>
                            <span class="text-xl font-bold text-gray-900">{{ $ticketsByStatus['pendientes'] + $ticketsByStatus['resueltos'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-building mr-2"></i>
                    Tickets por Área
                </h3>
                <div class="space-y-3">
                    @foreach($ticketsByArea as $area)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">{{ $area->area }}</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $area->tickets_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Recientes -->
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-clock mr-2"></i>
                Tickets Recientes
            </h3>
        </div>
        @if($recentTickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ticket
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usuario
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Área
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
                        @foreach($recentTickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600">#{{ $ticket->id }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-gray-900">{{ Str::limit($ticket->solicitud, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido_paterno }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $ticket->area->area }}</div>
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
                                            {{ $ticket->status->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->created_at ? $ticket->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No hay tickets recientes</p>
            </div>
        @endif
    </div>

    <!-- Información del Sistema -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">
                    <i class="fas fa-database mr-2"></i>
                    Información del Sistema
                </h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Versión de Laravel:</dt>
                        <dd class="text-sm text-gray-900">{{ app()->version() }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Versión de PHP:</dt>
                        <dd class="text-sm text-gray-900">{{ PHP_VERSION }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Última actualización:</dt>
                        <dd class="text-sm text-gray-900">{{ now()->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">
                    <i class="fas fa-cog mr-2"></i>
                    Acciones Rápidas
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('tickets.create') }}" class="block w-full text-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                        Crear Ticket
                    </a>
                    <a href="{{ route('usuarios.create') }}" class="block w-full text-center px-3 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100">
                        Nuevo Usuario
                    </a>
                    <a href="{{ route('areas.create') }}" class="block w-full text-center px-3 py-2 border border-purple-300 text-sm font-medium rounded-md text-purple-700 bg-purple-50 hover:bg-purple-100">
                        Nueva Área
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <h3 class="text-lg font-medium text-gray-900 mb-3">
                    <i class="fas fa-chart-line mr-2"></i>
                    Rendimiento
                </h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Tickets hoy:</dt>
                        <dd class="text-sm text-gray-900">
                            {{ \App\Models\Ticket::whereDate('created_at', today())->count() }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Esta semana:</dt>
                        <dd class="text-sm text-gray-900">
                            {{ \App\Models\Ticket::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Este mes:</dt>
                        <dd class="text-sm text-gray-900">
                            {{ \App\Models\Ticket::whereMonth('created_at', now()->month)->count() }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection