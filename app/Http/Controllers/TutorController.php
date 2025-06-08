<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentScore;
use App\Models\User;




class TutorController extends Controller
{

    //this is for the tutor dashboard
    public function dashboard()
    {
         // Fetch all users with role 'student'
        $students = User::where('role', 'student')->get();

        $courses = Course::all();  // Get all courses predefined in DB

        return view('tutor.dashboard', compact('students', 'courses'));
    }



    
    // this is to save the score of the student score
    public function storeScores(Request $request)
    {

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'courses' => 'required|array',
            'courses.*.id' => 'required|string',
            'courses.*.score' => 'required|numeric|min:0|max:100',
        ]);

        $studentId = $request->input('student_id');
        $courses = $request->input('courses'); // Must be an array

        foreach ($courses as $course) {
            DB::table('student_scores')->insert([
                'student_id' => $studentId,
                'course_id' => $course['id'], // match validation
                'score' => $course['score'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        return redirect()->back()->with('success', 'Scores submitted successfully!');
    }
        


    // this is for getting student score
    public function getStudentScores($studentId)
    {
        $scores = DB::table('student_scores')
            ->join('courses', 'student_scores.course_id', '=', 'courses.id')
            ->where('student_scores.student_id', $studentId)
            ->select('courses.name as course_name', 'student_scores.score')
            ->get();

        return response()->json($scores);
    }

    
    // Selecting student 
    public function selectStudent(Request $request)
    {
        $student = User::where('id', $request->student_id)->where('role', 'student')->firstOrFail();
        return view('tutor.enter-scores', compact('student'));
    }
}
