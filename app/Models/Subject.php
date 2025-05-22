<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $fillable = [
        'user_subject_id',
        'subject_name',
        'subject_description',
        'subject_code',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_subject_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
