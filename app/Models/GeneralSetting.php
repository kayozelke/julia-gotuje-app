<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings'; // Nazwa tabeli
    protected $fillable = ['key', 'value', 'description', 'updated_by']; // Pola do masowego wypełniania

    // Relation to the user who updated the category
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
