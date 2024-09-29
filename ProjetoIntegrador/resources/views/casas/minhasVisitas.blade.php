@extends('layouts.main')

@section('title', 'Minhas Solicitações de Visitas')

@section('content')

    <div class="container mt-5">
        <h1>Minhas Solicitações de Visitas</h1>

        @if($solicitacoes->isEmpty())
            <p>Você não tem solicitações de visita pendentes.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Data da Visita</th>
                        <th>Hora da Visita</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitacoes as $solicitacao)
                        <tr>
                            <td>{{ $solicitacao->data_visita }}</td>
                            <td>{{ $solicitacao->hora_visita }}</td>
                            <td>{{ $solicitacao->status }}</td>
                            <td>
                                <form action="{{ route('aceitar.visita', $solicitacao->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Aceitar</button>
                                </form>
                                <form action="{{ route('rejeitar.visita', $solicitacao->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Rejeitar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
