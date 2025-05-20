<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'user_teacher_id',
        'section_id',
        'room_id',
        'day',
        'start_time',
        'end_time'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_teacher_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'schedule_student', 'schedule_id', 'user_student_id')
            ->withTimestamps();
    }
}
