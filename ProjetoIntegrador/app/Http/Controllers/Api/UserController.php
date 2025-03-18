<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $userLogged = Auth::user();
    
        // Obtém o parâmetro 'target' da requisição, se existir
        $targetUserId = $request->query('target');
    
        // Inicia a consulta com a condição de que o usuário logado não deve ser listado
        $usersQuery = User::where('id', '!=', $userLogged->id)
            ->where(function ($query) use ($userLogged) {
                // Filtra usuários com quem o logado trocou mensagens (enviadas ou recebidas)
                $query->whereHas('messagesReceived', function ($query) use ($userLogged) {
                    $query->where('fk_id_user_from', $userLogged->id);
                })->orWhereHas('messagesSent', function ($query) use ($userLogged) {
                    $query->where('fk_id_user_to', $userLogged->id);
                });
            });
    
        // Se um 'target' foi fornecido, garanta que ele também será incluído
        if ($targetUserId) {
            $targetUser = User::find($targetUserId);
    
            if ($targetUser) {
                // Adiciona o usuário alvo à consulta
                $usersQuery->orWhere('id', $targetUserId);
            }
        }
    
        // Executa a consulta e recupera os usuários filtrados
        $users = $usersQuery->get();
    
        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }
    



    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }
    public function me()
    {
        $userLogged = Auth::user();
        return response()->json([
            'user' => $userLogged
        ], Response::HTTP_OK);
    }
}
