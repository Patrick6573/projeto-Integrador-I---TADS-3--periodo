<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use app\Models\User_Phone;
class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable;


    // Garanta que o campo `id` é tratado como string
    protected $keyType = 'string';
    public $incrementing = false;
    /**

     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'user_type',
        'user_registration_date',
        'user_photo',
        'user_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function phones()
    {
        return $this->hasMany(User_Phone::class, 'fk_id_user');
    }
    

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'fk_id_user_from');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'fk_id_user_to');
    }
}


