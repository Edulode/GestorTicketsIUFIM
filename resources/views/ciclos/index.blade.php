@extends('layouts.authenticated')

@section('title', 'Sistema de Ciclos Automáticos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Sistema de Ciclos Automáticos</h1>
                <p class="mt-2 text-sm text-gray-700">Los ciclos se generan automáticamente basados en la fecha actual</p>
            </div>
            <div class="flex space-x-3">
                <span class="inline-flex items-center px-3 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-50">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Ciclo Actual: {{ $cicloActual['codigo'] }}
                </span>
            </div>
        </div>
    </div>

    <!-- Información del Ciclo Actual -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg text-white">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">{{ $cicloActual['nombre'] }}</h2>
                    <p class="text-blue-100 mt-1">{{ $cicloActual['periodo'] }} {{ $cicloActual['year'] }}</p>
                    <p class="text-blue-100 text-sm mt-2">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $cicloActual['fecha_inicio']->format('d/m/Y') }} - {{ $cicloActual['fecha_fin']->format('d/m/Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">{{ $cicloActual['codigo'] }}</div>
                    <div class="text-blue-100 text-sm">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $cicloActual['dias_restantes'] }} días restantes
                    </div>
                    <div class="mt-2">
                        <div class="bg-blue-400 rounded-full h-2 w-32">
                            <div class="bg-white rounded-full h-2" style="width: {{ min(100, $cicloActual['progreso_porcentaje']) }}%"></div>
                        </div>
                        <span class="text-xs text-blue-100">{{ number_format($cicloActual['progreso_porcentaje'], 1) }}% completado</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cómo Funciona -->
    <div class="mb-8 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                <i class="fas fa-info-circle mr-2"></i>
                ¿Cómo Funciona el Sistema Automático?
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-bold">B</span>
                        </div>
                        <h4 class="font-semibold text-gray-900">Primer Semestre (B)</h4>
                    </div>
                    <p class="text-sm text-gray-600">
                        <strong>Enero - Junio:</strong> Si la fecha es antes o igual al 30 de junio, 
                        el ciclo será el año actual seguido de "B" (ej: 2025B)
                    </p>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-green-600 font-bold">A</span>
                        </div>
                        <h4 class="font-semibold text-gray-900">Segundo Semestre (A)</h4>
                    </div>
                    <p class="text-sm text-gray-600">
                        <strong>Julio - Diciembre:</strong> Si la fecha es después del 30 de junio, 
                        el ciclo será el año actual seguido de "A" (ej: 2025A)
                    </p>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex">
                    <i class="fas fa-lightbulb text-yellow-600 mt-1 mr-3"></i>
                    <div>
                        <h5 class="font-medium text-yellow-800">Ventajas del Sistema Automático</h5>
                        <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside">
                            <li>No necesitas crear ciclos manualmente</li>
                            <li>Los tickets se asignan automáticamente al ciclo correcto</li>
                            <li>No hay riesgo de duplicados o errores de asignación</li>
                            <li>El sistema se adapta automáticamente a los cambios de año</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtro por Año -->
    <div class="mb-6 bg-white shadow rounded-lg">
        <div class="p-6">
            <form method="GET" action="{{ route('ciclos.index') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Año</label>
                    <select id="year" name="year" 
                            class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @for($year = now()->year + 1; $year >= now()->year - 5; $year--)
                            <option value="{{ $year }}" {{ $filtroAnio == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-filter mr-2"></i>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Ciclos del Año Seleccionado -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                Ciclos del Año {{ $filtroAnio }}
            </h3>
        </div>
        
        @if(count($ciclosFiltrados) > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($ciclosFiltrados as $ciclo)
                    @php
                        $ticketsCount = $estadisticasCiclos[$ciclo['codigo']] ?? 0;
                        $esActual = $ciclo['codigo'] === $cicloActual['codigo'];
                    @endphp
                    <li class="hover:bg-gray-50 transition-colors duration-150 {{ $esActual ? 'bg-blue-50' : '' }}">
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <!-- Avatar/Icono -->
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full {{ $esActual ? 'bg-blue-100' : 'bg-orange-100' }} flex items-center justify-center">
                                            <i class="fas fa-calendar {{ $esActual ? 'text-blue-600' : 'text-orange-600' }} text-lg"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Información Principal -->
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="{{ route('ciclos.show', $ciclo['codigo']) }}" class="hover:text-blue-600">
                                                    {{ $ciclo['nombre'] }}
                                                </a>
                                            </h3>
                                            <span class="ml-2 text-sm text-gray-500 font-mono">
                                                {{ $ciclo['codigo'] }}
                                            </span>
                                            @if($esActual)
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-star mr-1"></i>
                                                    ACTUAL
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-1 flex items-center text-sm text-gray-500 space-x-4">
                                            <span>
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                {{ $ticketsCount }} tickets
                                            </span>
                                            <span>
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $ciclo['periodo'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Badges y Acciones -->
                                <div class="flex items-center space-x-3">
                                    <!-- Badge de Estado -->
                                    @if($ticketsCount > 0)
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
                                        <a href="{{ route('ciclos.show', $ciclo['codigo']) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($ticketsCount > 0)
                                            <a href="{{ route('tickets.index') }}?ciclo={{ $ciclo['codigo'] }}" 
                                               class="text-green-600 hover:text-green-900" title="Ver tickets">
                                                <i class="fas fa-ticket-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <!-- Estado Vacío -->
            <div class="text-center py-12">
                <div class="mx-auto h-12 w-12 text-gray-400">
                    <i class="fas fa-calendar text-4xl"></i>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay información para este año</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Selecciona un año diferente para ver los ciclos disponibles.
                </p>
            </div>
        @endif
    </div>
</div>

<script>
// Auto-submit del formulario cuando cambia el año
document.getElementById('year').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection
