<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'author',
        'year',
        'stock',
    ];

    // App\Models\Book
    // App\Models\Book.php
    // app/Models/Book.php

    public function orders()
    {
        return $this->hasMany(Order::class); // Relasi ke model Order
    }
}