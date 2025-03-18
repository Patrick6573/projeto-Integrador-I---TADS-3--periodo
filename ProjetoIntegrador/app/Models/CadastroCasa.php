<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroCasa extends Model
{
    public $timestamps = false;

    
    use HasFactory;
    protected $table = 'propertys'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $fillable = [
        'id', 
        'street',
    'number',
        'zip_code',
        "neighborhood",
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
        'fk_id_user', 
        'latitude',
        'longitude'
    ];
    
// Modelo CadastroCasa



public function files()
{
    return $this->hasMany(Property_files::class, 'fk_id_property', 'id');
}




public function owner()
    {
        return $this->belongsTo(User::class, 'fk_id_user');
    }



}
