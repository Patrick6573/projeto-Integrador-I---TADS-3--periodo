@extends('layouts.main')

@section('content')
    <div class="container">
        <h2>Minhas Visitas</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($visitas->isEmpty())
            <p>Você não tem visitas agendadas.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visitas as $visita)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($visita->date_visit)->format('d/m/Y') }}</td>
                            <td>{{ $visita->time_visit }}</td>
                            <td>{{ $visita->request_status }}</td>
                            <td>
                                @if (Auth::id() == $visita->fk_id_visitor)
                                    <button class="btn btn-warning btn-editar" data-id="{{ $visita->id_visit }}"
                                        data-date="{{ $visita->date_visit }}" data-time="{{ $visita->time_visit }}"
                                        data-bs-toggle="modal" data-bs-target="#modalEditarVisita">
                                        Editar
                                    </button>
                                @endif

                                @if (($visita->fk_id_visitor == Auth::id() && $visita->request_status == "CONFIRMADA") || (Auth::id() == $visita->fk_id_owner && $visita->request_status == "CONFIRMADA"))
                                    <form action="{{ route('visitas.cancelar', $visita->id_visit) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                    </form>
                                @endif

                                @if($visita->request_status == 'PENDENTE' && Auth::id() == $visita->fk_id_owner)
                                    <form action="{{ route('visitas.recusar', $visita->id_visit) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">Recusar</button>
                                    </form>
                                @endif
                                @if($visita->request_status == 'PENDENTE' && Auth::id() != $visita->fk_id_visitor && Auth::id() == $visita->fk_id_owner)
                                    <form action="{{ route('visitas.confirmar', $visita->id_visit) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                                    </form>
                                @endif


                                @if( ($visita->fk_id_visitor == Auth::id() && $visita->request_status  != "CONFIRMADA") ||$visita->request_status == 'RECUSADA' || $visita->request_status == 'CANCELADA')
                                    <form action="{{ route('visitas.excluir', $visita->id_visit) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE') <!-- Isso informa ao Laravel que o método é DELETE -->
                                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


    <!-- Modal de Edição -->
    <div class="modal fade" id="modalEditarVisita" tabindex="-1" aria-labelledby="modalEditarVisitaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarVisitaLabel">Editar Visita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="editDateVisit" class="form-label">Data:</label>
                            <input type="date" id="editDateVisit" name="date_visit" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="editTimeVisit" class="form-label">Hora:</label>
                            <input type="time" id="editTimeVisit" name="time_visit" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var editButtons = document.querySelectorAll(".btn-editar");

        editButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                var id = button.getAttribute("data-id");
                var date = button.getAttribute("data-date");
                var time = button.getAttribute("data-time");

                // Preenche os campos do formulário com os dados da visita
                document.getElementById("editDateVisit").value = date;
                document.getElementById("editTimeVisit").value = time;

                // Define a ação correta do formulário
                document.getElementById("editForm").action = "/visitas/" + id + "/atualizar";
            });
        });

        // Impede envio do formulário se nada mudou e fecha o modal
        document.getElementById("editForm").addEventListener("submit", function (event) {
            let newDate = document.getElementById("editDateVisit").value;
            let newTime = document.getElementById("editTimeVisit").value;

            if (newDate === originalDate && newTime === originalTime) {
                event.preventDefault(); // Cancela o envio do formulário

                // Fecha o modal
                let modal = document.getElementById("modalEditarVisita");
                let modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
            }
        });


    });
</script>