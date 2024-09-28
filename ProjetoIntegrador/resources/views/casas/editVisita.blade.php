@extends('layouts.main')

@section('title', 'Editar Visita')

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4">Editar Visita</h3>
    <form action="{{ route('visitas.update', $visita->id) }}" method="POST" class="shadow p-4 rounded bg-light mx-auto" style="max-width: 600px;">
        @csrf

        <div class="form-group">
            <label for="data_visita">Data desejada:</label>
            <input type="date" class="form-control form-control-sm" id="data_visita" name="data_visita" value="{{ $visita->data_visita }}" required>
        </div>

        <div class="form-group">
            <label for="hora_visita">Hora desejada:</label>
            <input type="time" class="form-control form-control-sm" id="hora_visita" name="hora_visita" value="{{ $visita->hora_visita }}" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Atualizar Visita</button>
    </form>
</div>
@endsection
