<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_videos extends Model
{
    use HasFactory;
    protected $table = 'property_videos';

    protected $fillable = [
        'id_video',
        'fk_id_property',
        'name_video',
        'shipping_date',
        'shipping_time',
    ];

    public $timestamps = true;
}
