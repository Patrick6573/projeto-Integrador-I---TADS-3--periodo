<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model{
    use HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'visitas';

    // Permitir atribuição em massa para os campos especificados
    protected $fillable = [
        'data_visita',
        'hora_visita',
        'status',
        'user_id',
        'casa_id',
    ];
// Relação com o usuário que solicitou a visita
public function usuario()
{
    return $this->belongsTo(User::class, 'user_id');
}

// Relação com a casa
public function casa()
{
    return $this->belongsTo(CadastroCasa::class, 'casa_id');
}
}