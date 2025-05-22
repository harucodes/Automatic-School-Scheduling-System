<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'user_room_id',
        'room_number',
        'capacity',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_room_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
