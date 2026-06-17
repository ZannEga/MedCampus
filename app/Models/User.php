<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Kasih tahu Laravel kalau Primary Key kamu bukan 'id' tapi 'id_user'
    protected $primaryKey = 'id_user';

    // Karena id_user kamu pakai NIM (Tipe CHAR/String), matikan fitur Auto Increment
    public $incrementing = false;

    // Kasih tahu kalau tipe key-nya adalah string
    protected $keyType = 'string';

    protected $fillable = [
        'id_user', 'user_name', 'user_email', 'password', 'id_role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}