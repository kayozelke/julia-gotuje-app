<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $table = 'images'; // Table name in the database

    // Mass assignable fields
    protected $fillable = [
        'post_id',
        'image_id',
        'priority',
        'updated_by',
    ];

    // Date fields
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relation to the user who updated the post
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function imageData(){
        return $this->belongsTo(Image::class, 'image_id');
    }
}
