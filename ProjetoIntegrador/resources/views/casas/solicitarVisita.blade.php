@extends('layouts.main')

@section('title', 'Solicitar Visita')

@section('content')

<div class="container mt-5">
<form action="{{ route('visit', $casa->id) }}" method="POST" class="shadow p-4 rounded bg-light mx-auto" style="max-width: 600px">

        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="data_visita">Data desejada:</label>
            <input type="date" class="form-control form-control-sm" id="data_visita" name="data_visita" required>
        </div>

        <div class="form-group">
            <label for="hora_visita">Hora desejada:</label>
            <input type="time" class="form-control form-control-sm" id="hora_visita" name="hora_visita" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
    </form>
</div>

@endsection
