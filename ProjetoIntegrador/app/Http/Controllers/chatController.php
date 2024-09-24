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
public function store(Request $request){
    $message = new Message();
    $message->id_menssage = Str::uuid()->toString();
    $message->fk_id_user_from = Auth::user()->id;
    $message->fk_id_user_to = $request->to;
    $message->shipping_date = Carbon::today();
    $message->shipping_time = now()->format('H:i:s'); 
    $message->date_received = Carbon::today();
    $message->time_received = now()->format('H:i:s');
    $message->content_menssage = $request->input('content');

    $message->save();

    Event::dispatch(new SendMessage($message, $request->fk_id_user_to));

}




}
