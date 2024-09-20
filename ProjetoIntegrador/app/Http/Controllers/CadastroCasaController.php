<?php

namespace App\Http\Controllers;

use App\Models\CadastroCasa;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class CadastroCasaController extends Controller
{
    public function cadastro(Request $request) {
        $cadastroCasa = new CadastroCasa;

        $cadastroCasa->id = Str::uuid()->toString();

        $cadastroCasa->street = $request->street;
        $cadastroCasa->number = $request->number;
        $cadastroCasa->zip_code = $request->zip_code;
        $cadastroCasa->city = $request->city;
        $cadastroCasa->state = $request->state;
        $cadastroCasa->complement = $request->complement;
        $cadastroCasa->reference_point = $request->reference_point;
        $cadastroCasa->number_rooms = $request->number_rooms;
        $cadastroCasa->number_bathrooms = $request->number_bathrooms;
        $cadastroCasa->property_size = $request->property_size;
        $cadastroCasa->rental_value = $request->rental_value;
        $cadastroCasa->property_description = $request->property_description;
        $cadastroCasa->property_type = $request->property_type;
        $cadastroCasa->property_status = $request->property_status;
        $cadastroCasa->property_title = $request->property_title;

        $cadastroCasa->save();

        return redirect('/');
    }
}
