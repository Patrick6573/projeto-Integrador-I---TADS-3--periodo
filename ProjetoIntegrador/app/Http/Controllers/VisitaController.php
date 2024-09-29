<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;  // Assumindo que você já tem um modelo de Visita
use App\Models\CadastroCasa; // Assumindo que CadastroCasa já está implementado
use Illuminate\Support\Facades\Auth;

class VisitaController extends Controller{
    
    //Exibir formulario
    public function exibirFormulario($idCasa) {
        // Verifica se a casa existe
        $casa = CadastroCasa::find($idCasa);
        
        // Se a casa não existir, redireciona com uma mensagem de erro
        if (!$casa) {
            // Aqui você pode usar 'with' para passar a mensagem de erro
            return redirect()->back()->with('error', 'Casa não encontrada.');
        }
    
        // Retorna a view do formulário de visita, passando a casa
        return view('casas.solicitarVisita', compact('casa'));
    }
    
    // Função para solicitar uma visita pelo usuário comum
    public function solicitarVisita(Request $request, $idCasa) {
        // Verifica se a casa existe
        $casa = CadastroCasa::find($idCasa);
        
        // Se a casa não existir, redireciona com uma mensagem de erro
       if (!$casa) {
            return redirect()->back()->with('error', 'Casa não encontrada.');
        }
            
        // Checa se o usuário está autenticado
        if (Auth::check()) {
            $visita = new Visita;
            $visita->user_id = Auth::id();  // ID do usuário logado
            $visita->casa_id = $idCasa; // ID da casa sendo visitada
            $visita->hora_visita = $request->hora_visita;  // Hora da visita
            $visita->data_visita = $request->data_visita;
            $visita->status = 'Pendente'; // A visita começa com status Pendente

            $visita->save();
                // Notificar o dono da casa
            $donoDaCasa = $casa->user; // Supondo que a relação está definida no modelo CadastroCasa

            // Notification::send($donoDaCasa, new VisitaSolicitada($visita));
            //     return redirect()->back()->with('success', 'Solicitação de 
            //     visita enviada com sucesso!');
        
        } else {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para solicitar uma visita.');
        }
    }

        // Função para exibir as solicitações de visitas ao dono do imóvel
        public function exibirSolicitacoes() {
            // Checa se o usuário está autenticado
            if (Auth::check()) {
                // Obtenha as casas do dono logado
                $casas = CadastroCasa::where('user_id', Auth::id())->get();
                // Obtenha as visitas solicitadas para essas casas
                $solicitacoes = Visita::whereIn('casa_id', $casas->pluck('id'))->where('status', 'Pendente')->get();
                
                return view('casas.minhasVisitas', compact('solicitacoes'));
            } else {
                return redirect()->route('login')->with('error', 'Você precisa estar logado para ver as solicitações.');
            }
        }

    public function edit($id){
        // Busca a visita pelo ID
        $visita = Visita::findOrFail($id);

        // Retorna a view de edição com a visita
        return view('casas.editVisita', compact('visita'));
    }

    public function update(Request $request, $id){
        // Valida os dados do formulário
        $request->validate([
            'data_visita' => 'required|date',
            'hora_visita' => 'required|date_format:H:i',
        ]);

        // Busca a visita pelo ID
        $visita = Visita::findOrFail($id);

        // Atualiza os dados da visita
        $visita->data_visita = $request->data_visita;
        $visita->hora_visita = $request->hora_visita;
        $visita->save();

        // Redireciona com uma mensagem de sucesso
        return redirect()->route('minhasVisitas')->with('success', 'Visita atualizada com sucesso!');
    }
}

        

