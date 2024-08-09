<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VideoLog;
use Illuminate\Http\Request;

class VideoLogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $lecture_id = $request->lecture_id;

        $videoLog = VideoLog::where('user_id', $user_id)->where('lecture_id', $lecture_id)->first();
        if($videoLog) {
            return $videoLog;
        }

        $videoLog = VideoLog::create([
            'user_id' => $user_id,
            'lecture_id' => $lecture_id,
            'datetime' => date('Y-m-d H:i:s', time())
        ]);

        return $videoLog;
    }

    /**
     * Display the specified resource.
     */
    public function show(VideoLog $videoLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoLog $videoLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoLog $videoLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoLog $videoLog)
    {
        //
    }
}
