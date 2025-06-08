<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class StudentScore extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'course_id', 'score'];

    public function student()
    {
        return $this->hasMany(StudentScore::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }
}
