<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User_Phone;
use Illuminate\Support\Facades\Auth;

class UserPhoneController extends Controller
{
    
    public function storePhone(Request $request)
    {
        $user = Auth::user();
        // Validação dos dados de entrada
        $request->validate([
            'user_phone1' => 'required|string|max:15', // Validação para o primeiro telefone
            'user_phone2' => 'nullable|string|max:15', // Validação para o segundo telefone (opcional)
        ]);

        
        // Primeiro telefone
        $phone1 = new User_Phone;
        $phone1->id_phone = Str::uuid()->toString();
        $phone1->user_phone = $request->user_phone1; // Primeiro telefone
        $phone1->fk_id_user = $user->id;
        $phone1->save(); // Salva o primeiro telefone

        // Se o segundo telefone foi fornecido, salvar também
        if ($request->has('user_phone2') && !empty($request->user_phone2)) {
            $phone2 = new User_Phone;
            $phone2->id_phone = Str::uuid()->toString();
            $phone2->user_phone = $request->user_phone2; // Segundo telefone
            $phone2->fk_id_user = $user->id;
            $phone2->save(); // Salva o segundo telefone
        }
    }


}
