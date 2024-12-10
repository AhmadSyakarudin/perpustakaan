<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name', 'email', 'password'];

    public function orders()
    {
        return $this->hasMany(Order::class);  // Relasi ke Order
    }
}