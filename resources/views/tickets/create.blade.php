@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Ticket</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <label>Ciclo:</label>
        <select name="ciclo_id" required>
            @foreach($ciclos as $ciclo)
                <option value="{{ $ciclo->id }}">{{ $ciclo->ciclo }}</option>
            @endforeach
        </select>
        <br>
        <label>Tipo:</label>
        <select name="tipo_id" required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>
        <br>
        <label>Fecha:</label>
        <input type="datetime-local" name="fecha" required>
        <br>
        <label>Área:</label>
        <select name="area_id" required>
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
            @endforeach
        </select>
        <br>
        <label>Usuario:</label>
        <select name="usuario_id" required>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->nombre }}</option>
            @endforeach
        </select>
        <br>
        <label>Solicitud:</label>
        <textarea name="solicitud" required></textarea>
        <br>
        <label>Subárea:</label>
        <select name="subarea_id" required>
            @foreach($subareas as $subarea)
                <option value="{{ $subarea->id }}">{{ $subarea->nombre }}</option>
            @endforeach
        </select>
        <br>
        <label>Asunto:</label>
        <select name="asunto_id" required>
            @foreach($asuntos as $asunto)
                <option value="{{ $asunto->id }}">{{ $asunto->tipo }}</option>
            @endforeach
        </select>
        <br>
        <label>Tipo de solicitud:</label>
        <select name="tipo_solicitud_id" required>
            @foreach($tipos_solicitud as $ts)
                <option value="{{ $ts->id }}">{{ $ts->tipo_solicitud }}</option>
            @endforeach
        </select>
        <br>
        <label>Categoría del servicio:</label>
        <select name="categoria_servicio_id" required>
            @foreach($categorias_servicio as $cat)
                <option value="{{ $cat->id }}">{{ $cat->categoria }}</option>
            @endforeach
        </select>
        <br>
        <label>Status:</label>
        <select name="status_id" required>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->status }}</option>
            @endforeach
        </select>
        <br>
        <label>Técnico:</label>
        <select name="tecnico_id">
            <option value="">-- Sin asignar --</option>
            @foreach($tecnicos as $tec)
                <option value="{{ $tec->id }}">{{ $tec->nombre }}</option>
            @endforeach
        </select>
        <br>
        <label>Incidencia real:</label>
        <textarea name="incidencia_real"></textarea>
        <br>
        <label>Servicio realizado:</label>
        <textarea name="servicio_realizado"></textarea>
        <br>
        
        <label>Fecha de atención:</label>
        <input type="datetime-local" name="fecha_atencion">
        <br>

        <label>Notas:</label>
        <textarea name="notas"></textarea>
        <br>

        <label>Observaciones:</label>
        <textarea name="observaciones"></textarea>

        <br>
        <button type="submit">Guardar Ticket</button>
    </form>
</div>
@endsection