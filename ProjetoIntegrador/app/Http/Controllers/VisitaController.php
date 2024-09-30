<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;  
use App\Models\CadastroCasa; 
use Illuminate\Support\Facades\Auth;

class VisitaController extends Controller{
    
    //Exibir formulario
    public function showFormVisit($id) {
        // Verifica se a casa existe
        $casa = CadastroCasa::find($id);
        
        if (!$casa) {
            
            return redirect()->back()->with('error', 'Casa não encontrada.');
        }
        
        return view('casas.formSolicitarVisit', compact('casa'));
    }
    
    // Função para solicitar uma visita pelo usuário comum
    public function solicitarVisit(Request $request, $idCasa) {
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
            $visita->time_visit = $request->time_visit;  // Hora da visita
            $visita->dat_visit = $request->date_visit;
            $visita->status = 'Pendente'; // A visita começa com status Pendente

            $visita->save();
                // Notificar o dono da casa
            $donoDaCasa = $casa->user; // Supondo que a relação está definida no modelo CadastroCasa

            // Notification::send($donoDaCasa, new VisitaSolicitada($visita));
            //     return redirect()->back()->with('success', 'Solicitação de 
            //     visita enviada com sucesso!');
        
        } else {
            return redirect()->route('login')->with( 'error', 'Você precisa estar logado para solicitar uma visita.');
        }
    }

        // Função para exibir as solicitações de visitas ao dono do imóvel
        public function showSolicitacion() {
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

        public function acceptVisit($id) {
            $visita = Visita::findOrFail($id);
            $visita->status = 'Aceita'; // Ou outro status que você desejar
            $visita->save();
        
            return redirect()->route('minhas.visitas')->with('success', 'Visita aceita com sucesso!');
        }
        
        public function rejectVisit($id) {
            $visita = Visita::findOrFail($id);
            $visita->status = 'Rejeitada'; // Ou outro status que você desejar
            $visita->save();
        
            return redirect()->route('minhas.visitas')->with('success', 'Visita rejeitada com sucesso!');
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


    public function cancelarVisita($id) {
        
        if (Auth::check()) {
            
            $visita = Visita::find($id);
    
            // Verifica se a visita existe e se pertence ao usuário
            if ($visita && $visita->user_id == Auth::id()) {
                
                $visita->status = 'Cancelada';
                $visita->save();
    
                return redirect()->route('minhas.visitas')->with('success', 'Visita cancelada com sucesso!');
            } else {
                return redirect()->route('minhas.visitas')->with('error', 'Visita não encontrada ou você não tem permissão para cancelá-la.');
            }
        }
    
        return redirect()->route('login')->with('error', 'Você precisa estar logado para cancelar uma visita.');
    }
    


}

        

