<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'books',
        'name_customer',
        'sum_book'
    ];

    protected $casts = [
        'books' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);  // Relasi ke User
    }
}