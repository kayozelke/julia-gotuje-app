<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings'; // Table name
    protected $fillable = ['key', 'value', 'description', 'updated_at', 'updated_by']; // Mass assignable fields

    // Relation to the user who updated the category
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
