<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroCasa extends Model
{
    public $timestamps = false;
    
    use HasFactory;
    protected $table = 'propertys'; // Nome da tabela, ajuste conforme necessário
    public $incrementing = false; // Desativa o autoincremento
    protected $keyType = 'string'; // Define o tipo da chave como string para UUID

    protected $fillable = [
        'id', // Chave primária
        'street',
        'number',
        'zip_code',
        'city',
        'state',
        'complement',
        'reference_point',
        'number_rooms',
        'number_bathrooms',
        'property_size',
        'rental_value',
        'property_description',
        'property_type',
        'property_status',
        'property_title',
        'fk_id_user', // Inclua outros campos aqui conforme necessário
    ];
}
