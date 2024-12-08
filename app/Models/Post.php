<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Nazwa tabeli w bazie danych

    // Pola, które można masowo przypisywać
    protected $fillable = [
        'title',
        'url',
        'template_type',
        'content',
        'parent_category_id',
        'created_by',
        'updated_by',
    ];

    // Pola dat
    protected $dates = [
        'created_at',
        'updated_at',
    ];

}