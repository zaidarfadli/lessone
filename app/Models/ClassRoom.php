<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;


    protected $fillable = [
        "name",
        "class_level",
        "subject",
        "unique_code",
        "description",
        'teacher_id'
    ];


    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_classrooms', 'class_room_id', 'student_id');
    }
}
