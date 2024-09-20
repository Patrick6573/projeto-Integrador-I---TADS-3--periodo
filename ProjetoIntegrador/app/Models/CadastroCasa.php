<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadastroCasa extends Model
{
    public $timestamps = false;
    protected $table = 'propertys';
    use HasFactory;
}
