<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Subject;

class SubjectApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locale = request()->header('locale');

        $subjects = Subject::where('locale', $locale)
        ->with(['courses.lectures' => function ($query) {
            $query->withCount('videoLogs');
        }])
        ->withCount([
            'lectures' => function ($query) {
                $query->where('status', 'created');
            }, 'questions' => function ($query) {
                $query->where('status', 'created');
            }, 'courses' => function ($query) {
                $query->where('status', 'created');
            }, 
        ])
        ->withSum('lectures', 'duration')
        ->get();
        
        $exist_videos = [];
        foreach ($subjects as $key => $value) {
            if( $value->lectures_count > 0 ) {
                $value->video_log_count = $value->courses->sum(function ($course) {
                    return $course->lectures->sum('video_logs_count');
                });
                $exist_videos[] = $value;
            }
        }

        return response()->json([
            'subjects' => $exist_videos, 
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
}
