<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'user_section_id',
        'section_name',
        'section_level',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_section_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    
}
