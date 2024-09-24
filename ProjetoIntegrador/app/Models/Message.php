<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    protected $table = 'menssages';
    public $timestamps = false;

    protected $fillable = ['shipping_date','shipping_time',
        'content_menssage','time_received','date_received'
    ];

}
