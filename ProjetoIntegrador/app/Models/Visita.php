<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model{
    use HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'visits';
    protected $primaryKey = 'id_visit';
    protected $keyType = 'string'; // Tipo da chave (UUID é string)

    // Permitir atribuição em massa para os campos especificados
    protected $fillable = [
        'id_visit',
        'date_visit',
        'time_visit',
        'status_visit',
    //    'date_visit',
    //    'time_visit',
    //    'status_visit',
    //    'user_id',
     //   'casa_id',
    ];
// Relação com o usuário que solicitou a visita
public function usuario()
{
    return $this->belongsTo(User::class, 'user_id');
}
public $timestamps = false;

// Relação com a casa
public function casa()
{
    return $this->belongsTo(CadastroCasa::class, 'casa_id');
}
}