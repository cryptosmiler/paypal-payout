<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Question;
use App\Models\Setting;
use App\Models\QuestionLog;
use App\Models\Distribution;

class LectureApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $randomAnswers = true;
        $course_id = $request->course_id;
        $user_id = $request->user_id;

        $lectures = Lecture::where('course_id', $course_id)            
            ->withCount([
                'questions' => function ($query) {
                    $query->where('status', 'created');
                }, 
                'videoLogs'
            ])
            ->with([
                'questions' => function ($query) use ($user_id){
                    $query->where('status', 'created')
                        ->with(['userQuestionLog' => function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }]);
                },
                'course' => function ($query) use ($course_id, $user_id) {
                    $query->with(['transactions' => function ($query) use ($course_id, $user_id) {
                        $query->where([
                            'course_id' => $course_id, 
                            'user_id' => $user_id, 
                            'type' => "Promo Code", 
                        ]);
                    }]);
                },
                'transactions' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                }, 
                'distributions' => function($query) use ($user_id) {
                    $query->select('lecture_id', 'user_id', 'type')
                            ->selectRaw('count(*) as total')
                            ->groupBy('lecture_id', 'user_id', 'type');
                }, 
                'teacher' => function($query) {
                    $query->select('id', 'decrease');
                }
            ])
            ->simplePaginate(1);
        
        foreach ($lectures as $lecture) {
            foreach ($lecture->questions as $question) {
                $question->enableRandomization(); // Enable randomization
            }
            $lecture->makeHidden(["video", "video_40s", "video_name"]);
        }
        
        $settings = Setting::pluck('value', 'key')->toArray();

        return response()->json([
            'lectures' => $lectures, 
            'settings' => $settings, 
            "status" => "success"
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkQs(Request $request) 
    {
        $question = Question::find($request->question_id);

        $questionLogCount = QuestionLog::where([
            'question_id' => $request->question_id,
            'user_id' => $request->user_id
        ])->count();

        $status = $question->answer[0] == $request->selectedAs ? "right" : "wrong";

        if($questionLogCount == 0) {
            QuestionLog::create([
                'question_id' => $request->question_id,
                'user_id' => $request->user_id,
                'answer' => $request->selectedAs, 
                'status' => $status
            ]);
        }

        return $status;
    }
}
