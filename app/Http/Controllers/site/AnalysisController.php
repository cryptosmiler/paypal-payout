<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Question;

class AnalysisController extends Controller
{
    public function analysis(Request $request) 
    {

        $teachers = Admin::where('role', 'Teacher')->get();
        $subjects = [];

        if($request->teacher) 
        {
            $subjects = Subject::where('admin_id', $request->teacher)->get();
        }

        $courses = [];
        if($request->subject) 
        {
            $courses = Course::where('subject_id', $request->subject)->get();
        }

        $lectures = [];
        if($request->course) 
        {
            $lectures = Lecture::where('course_id', $request->course)->get();
        }

        $questions = [];
        if($request->lecture) 
        {
            $questions = Question::where('lecture_id', $request->lecture)->get();
        }

        return view('analysis.index', compact('teachers', 'subjects', 'courses', 'lectures', 'questions'));
    }
}
