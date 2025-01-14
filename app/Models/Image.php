<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images'; // Table name in the database

    // Mass assignable fields
    protected $fillable = [
        'title',
        'label',
        'file_location',
        'medium_file_location',
        'thumbnail_location',
        'created_by',
        'updated_by',
    ];

    // Date fields
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
