<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\QuestionLog;
use App\Models\Question;
use App\Models\Distribution;
use Illuminate\Http\Request;

use DB;

class QuestionLogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $question_id = $request->question_id;
        $type = $request->type;

        $question = Question::find($question_id);

        $count = Distribution::where('user_id', $user_id)->where('lecture_id', $question->lecture_id)->where("type", $type)->count();

        if($count >= 3) {
            return response()->json([
                'questionLogs' => [], 
                'question' => $question, 
                "status" => "success", 
                'count' => $count
            ], 200);
        }

        Distribution::create([
            'user_id' => $user_id,
            'lecture_id' => $question->lecture_id,
            'type' => $type
        ]);

        $questionLogs = QuestionLog::where('question_id', $question_id)
            ->select('answer', 'status', DB::raw('COUNT(*) as total'))
            ->groupBy('answer', 'status')
            ->get();
        
        $questionLog = QuestionLog::where('user_id', $user_id)
            ->where('question_id', $question_id)
            ->select('answer', 'status', DB::raw('COUNT(*) as total'))
            ->groupBy('answer', 'status')
            ->first();


        return response()->json([
            'questionLogs' => $questionLogs, 
            'questionLog' => $questionLog, 
            'question' => $question, 
            "status" => "success", 
            "count" => $count + 1
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
    public function show(QuestionLog $questionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionLog $questionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuestionLog $questionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionLog $questionLog)
    {
        //
    }
}
