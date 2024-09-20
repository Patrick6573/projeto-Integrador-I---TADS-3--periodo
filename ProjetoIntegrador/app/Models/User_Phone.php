<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Phone extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'users_phone';
    
    public function user_phones(){
        return $this->hasMany('App\Models\User_Phone');
    }
}
