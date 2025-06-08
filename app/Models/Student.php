<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email']; //this is to allow mass filling fields

    public function score()
    {
        return $this->hasMany(StudentScore::class); //student is allowed to have many score
    }
}
