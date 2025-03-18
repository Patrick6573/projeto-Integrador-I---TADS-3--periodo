<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;
use App\Models\CadastroCasa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VisitaController extends Controller
{

    //Exibir formulario
    public function showFormVisit($id)
    {
        // Verifica se a casa existe
        $casa = CadastroCasa::find($id);

        if (!$casa) {

            return redirect()->back()->with('error', 'Casa não encontrada.');
        }

        return view('casas.formSolicitarVisit', ['id' => $id]);
    }

    // Função para solicitar uma visita pelo usuário comum
    public function solicitarVisit(Request $request, $idCasa)
    {
        // Verifica se a casa existe
        $casa = CadastroCasa::find($idCasa);
        $owner = $casa->fk_id_user;
        if (!$casa) {
            return redirect()->back()->with('error', 'Casa não encontrada.');
        }

        if (Auth::check()) {
            $visita = new Visita;
            $visita->id_visit = Str::uuid();
            $visita->date_visit = $request->date_visit;
            $visita->time_visit = $request->time_visit;
            $visita->request_status = 'PENDENTE';

            $visita->fk_id_visitor = Auth::id();
            $visita->fk_id_property = $idCasa;
            $visita->fk_id_owner = $owner;
            $visita->save();

            return redirect()->route('casa', ['id' => $idCasa])
                ->with('success', 'Visita solicitada com sucesso!');
        }

        return redirect()->route('login')->with('error', 'Você precisa estar logado para solicitar uma visita.');
    }



    public function minhasVisitas()
    {
        $userId = Auth::id(); // Obtém o ID do usuário autenticado

        // Busca visitas onde o usuário é o visitante
        $visitas = Visita::where('fk_id_visitor', $userId)
            ->orWhere('fk_id_owner', $userId)->get();


        return view('casas.minhasVisitas', compact('visitas'));
    }


    public function confirmarVisita($id)
    {
        // Busca a visita pelo campo 'id_visit' explicitamente
        $visita = Visita::where('id_visit', $id)->first();

        if (!$visita) {
            return redirect()->back()->with('error', 'Visita não encontrada.');
        }

        // Atualiza o status
        $visita->request_status = 'CONFIRMADA';
        $visita->save();

        return redirect()->back()->with('success', 'Visita confirmada com sucesso!');
    }
    public function cancelar($id)
    {
        $visita = Visita::findOrFail($id);
        $visita->request_status = 'CANCELADA';
        $visita->save();

        return redirect()->back()->with('sucess', 'Visita cancelada com sucesso!');
    }
    public function recusar($id)
    {
        $visita = Visita::findOrFail($id);
        $visita->request_status = 'RECUSADA';
        $visita->save();

        return redirect()->back()->with('sucess', 'Visita recusada com sucesso!');
    }
    
    public function excluir($id)
{
    $visita = Visita::findOrFail($id);
    $visita->delete($id);
    return redirect()->back()->with('sucess', 'Visita excluida com sucesso!');
}






    public function update(Request $request, $id)
    {
        // Encontra a visita pelo ID
        $visita = Visita::find($id);

        // Verifica se a visita existe
        if (!$visita) {
            return redirect()->back()->with('error', 'Visita não encontrada.');
        }

        // Atualiza os dados da visita
        $visita->date_visit = $request->date_visit;
        $visita->request_status = "PENDENTE";
        $visita->time_visit = $request->time_visit;
        $visita->save();

        return redirect()->back()->with('success', 'Visita atualizada com sucesso!');
    }
}
