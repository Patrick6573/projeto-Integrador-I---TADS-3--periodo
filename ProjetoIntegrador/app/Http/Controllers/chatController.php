<?php

namespace App\Http\Controllers;

use App\Events\Chat\SendMessage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;




class chatController extends Controller
{
    

    public function listMessages(User $user)
{
    $userFrom = Auth::user()->id;
    $userTo = $user->id;

    // Busca as mensagens entre dois usuários
    $messages = Message::where(function ($query) use ($userFrom, $userTo) {
        $query->where([
            'fk_id_user_from' => $userFrom,
            'fk_id_user_to' => $userTo
        ]);
    })->orWhere(function ($query) use ($userFrom, $userTo) {
        $query->where([
            'fk_id_user_from' => $userTo,
            'fk_id_user_to' => $userFrom
        ]);
    })->orderBy('shipping_date', 'ASC')
      ->orderBy('shipping_time', 'ASC')->get();

    // Verifica se há mensagens retornadas
    if ($messages->isEmpty()) {
        return response()->json([
            'message' => 'Nenhuma mensagem encontrada.'
        ], Response::HTTP_NOT_FOUND);
    }

    // Retorna as mensagens em formato JSON
    return response()->json([
        'messages' => $messages
    ], Response::HTTP_OK);
}
public function store(Request $request)
{
    $message = new Message();
    $message->id = Str::uuid()->toString();
    $message->fk_id_user_from = Auth::user()->id; // Quem enviou
    $message->fk_id_user_to = $request->to; // Para quem a mensagem está sendo enviada
    $message->shipping_date = Carbon::today(); // Data de envio
    $message->shipping_time = now()->format('H:i:s'); // Hora de envio
    $message->date_received = Carbon::today(); // Data em que a mensagem foi recebida
    $message->time_received = now()->format('H:i:s'); // Hora em que a mensagem foi recebida
    $message->content = $request->input('content'); // Conteúdo da mensagem

    // Salva a mensagem no banco de dados
    $message->save();

    // Dispara o evento para enviar a mensagem pelo WebSocket
    Event::dispatch(new SendMessage($message, $request->to));

}





}
