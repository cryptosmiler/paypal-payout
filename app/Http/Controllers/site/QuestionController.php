<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Admin;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Lecture;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;

use Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $questions = Question::where('id', '>', 0);
        $subjects = Subject::get();
        $lectures = Lecture::where('status', 'created')->get();
        $courses = Course::where('status', 'created')->get();

        if( Auth::guard('admin')->user()->role == Admin::$ROLE_TEACHER ) {
            $questions = $questions->where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created');
            $lectures = Lecture::where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created')->get();
            $courses = Course::where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created')->get();
        }

        $teacher = $request->query("teacher");
        if($teacher) {
            $questions = $questions->with('admin')->whereHas('admin', function ($query) use ($teacher) {
                // Add additional conditions if needed
                $query->whereRaw(DB::Raw("CONCAT(first_name, ' ', last_name) LIKE '%$teacher%'"));
            });
        }

        // if($request->query("subject")) {
        //     $questions = $questions->where('subject_id', $request->query('subject'));
        // }

        // if($request->query("course")) {
        //     $questions = $questions->where('course_id', $request->query('course'));
        // }

        // if($request->query("lecture")) {
        //     $questions = $questions->where('lecture_id', $request->query('lecture'));
        // }

        if($request->query("question")) {
            $lectures = $lectures->where('question', "LIKE", "%".$request->query('question')."%");
        }

        if($request->query("answer")) {
            $lectures = $lectures->where('answer', "LIKE", "%".$request->query('answer')."%");
        }

        if($request->query("course_id")) {
            $questions = $questions->where('course_id', $request->query('course_id'));
        }

        if($request->query("lecture_id")) {
            $questions = $questions->where('lecture_id', $request->query('lecture_id'));
        }

        if($request->query("difficulty")) {
            $questions = $questions->where('difficulty', $request->query('difficulty'));
        }

        $questions = $questions->get();

        if(!$request->query("course_id") || !$request->query("lecture_id")) 
        {
            $questions = [];
        }

        return view('question.index', compact('questions', 'subjects', 'courses', 'lectures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request )
    {
        $courses = Course::get();
        $subjects = Subject::get();
        $lectures = Lecture::get();
        $course = [];
        $lecture = [];
        if($request->course) {
            $course = Course::find($request->course);
        }
        if($request->lecture) {
            $lecture = Lecture::find($request->lecture);
        }

        return view('question.create', compact('courses', 'subjects', 'lectures', 'course', 'lecture'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {

        $question = Question::create([
            'admin_id'          => Auth::guard('admin')->user()->id, 
            'subject_id'        => $request->subject_id, 
            'course_id'         => $request->course_id, 
            'lecture_id'        => $request->lecture_id, 
            'question'          => $request->question, 
            'answer'            => $request->answer, 
            'difficulty'        => $request->difficulty
        ]);

        return redirect()->route('question.index', 'course_id='.$request->course_id."&lecture_id=".$request->lecture_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $courses = Course::get();
        $subjects = Subject::get();
        $lectures = Lecture::get();

        return view('question.edit', compact('question', 'courses', 'subjects', 'lectures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->subject_id       = $request->subject_id;
        $question->course_id        = $request->course_id;
        $question->lecture_id       = $request->lecture_id;
        $question->question         = $request->question;
        $question->answer           = $request->answer;
        $question->difficulty       = $request->difficulty;
        $question->save();

        return redirect()->route('question.index', 'course_id='.$request->course_id."&lecture_id=".$request->lecture_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->status = "deleted";
        $question->save();

        return redirect()->back();
    }
}
