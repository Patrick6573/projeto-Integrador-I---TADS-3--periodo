<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\CadastroCasa;

class Property_photos extends Model
{
    public $timestamps = false;
    protected $table = 'property_photos';
    use HasFactory;

    public $incrementing = false; // Desativa autoincremento
    protected $keyType = 'string';
    //adição das linhas
      
    protected $fillable = [
        'id_photo', 
        'fk_id_property', 
        'shipping_date', 
        'shipping_time',
        'name_photo', 
         // Adicione aqui o campo da imagem
    ];

    public function property()
    {
        return $this->belongsTo(CadastroCasa::class, 'fk_id_property', 'id');
    }
}
