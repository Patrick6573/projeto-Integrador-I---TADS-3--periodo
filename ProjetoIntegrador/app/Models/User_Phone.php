<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class User_Phone extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_phone)) {
                $model->id_phone = Str::uuid()->toString();
            }
        });
    }
    public $timestamps = false;
    protected $table = 'users_phone';
    
    protected $fillable = [
        'user_phone',  // Campo que armazena o número de telefone
        'fk_id_user',  // Chave estrangeira que referencia o usuário
    ];
    
    public function user()
{
    return $this->belongsTo(User::class, 'fk_id_user');
}
}
