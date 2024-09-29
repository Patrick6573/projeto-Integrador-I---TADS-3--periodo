@extends('layouts.main')

@section('title', 'Solicitar Visita')

@section('content')

<div class="container mt-5">
    <form action="{{ route('enviarVisit', $casa->id{1}) }}" method="POST" class="shadow p-4 rounded bg-light mx-auto" style="max-width: 600px">
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
            <label for="date_visit">Data desejada:</label>
            <input type="date" class="form-control form-control-sm" id="date_visit" name="date_visit" required>
        </div>

        <div class="form-group">
            <label for="time_visit">Hora desejada:</label>
            <input type="time" class="form-control form-control-sm" id="time_visit" name="time_visit" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Enviar</button>
    </form>
</div>

@endsection
