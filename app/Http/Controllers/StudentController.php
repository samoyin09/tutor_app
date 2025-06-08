<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    //Student dashboard controller
    public function dashboard(){
        return view('student.dashboard');
    }
}
