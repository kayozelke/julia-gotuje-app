<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Nazwa tabeli w bazie danych

    // Pola, które można masowo przypisywać
    protected $fillable = [
        'name',
        'parent_id',
        'updated_by',
    ];

    // Pola dat
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}