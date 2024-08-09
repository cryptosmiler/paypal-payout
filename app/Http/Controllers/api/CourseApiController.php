<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Subject;
use App\Models\Course;


class CourseApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subject_id = $request->subject_id;

        $subject = Subject::find($subject_id);
        $courses = Course::where('subject_id', $subject_id)
            ->withCount([
                'questions' => function ($query) {
                    $query->where('status', 'created');
                }, 
                'lectures' => function ($query) {
                    $query->where('status', 'created');
                }
            ])
            ->withSum('lectures', 'duration')
            ->where('status', 'created')
            ->get();

        return response()->json([
            'subject' => $subject, 
            'courses' => $courses, 
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
