<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $table = 'messages';
    public $timestamps = false;

    protected $fillable = ['id','shipping_date','shipping_time',
        'content','time_received','date_received'
    ];

}
