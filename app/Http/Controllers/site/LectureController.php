<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Admin;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

use Auth;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        $lectures = Lecture::query();
        $courses = Course::where('status', 'created')->get();
        $subjects = Subject::get();

        if( Auth::guard('admin')->user()->role == Admin::$ROLE_TEACHER ) {
            $lectures = $lectures->where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created');
            $courses = Course::where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created')->get();
            $subjects = Subject::where('admin_id', Auth::guard('admin')->user()->id)->get();
        }

        $teacher = $request->query("teacher");
        if($teacher) {
            $lectures = $lectures->with('admin')->whereHas('admin', function ($query) use ($teacher) {
                // Add additional conditions if needed
                $query->whereRaw(DB::Raw("CONCAT(first_name, ' ', last_name) LIKE '%$teacher%'"));
            });
        }

        if($request->query("subject")) {
            $lectures = $lectures->where('subject_id', $request->query('subject'));
        }

        if($request->query("course")) {
            $lectures = $lectures->where('course_id', $request->query('course'));
        }

        if($request->query("title")) {
            $lectures = $lectures->where('title', "LIKE", "%".$request->query('title')."%");
        }

        if($request->query("order")) {
            $lectures = $lectures->where('order', "LIKE", $request->query('order'));
        }

        if($request->query("course_id")) {
            $lectures = $lectures->where('course_id', $request->query('course_id'));
        }

        if($request->query("lecture_id")) {
            $lectures = $lectures->where('lecture_id', $request->query('lecture_id'));
        }

        $lectures = $lectures->withCount([
            'questions' => function ($query) {
                $query->where('status', 'created');
            }, 
            'transactions' => function ($query) {
                $query->where('type', 'Video');
            }, 
        ])
        ->get();

        if(!$request->query("course_id") && !$request->query("lecture_id")) {
            $lectures = [];
        }

        return view('lecture.index', compact('lectures', 'subjects', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $courses = Course::get();
        $subjects = Subject::get();
        $course = Course::find($request->course);

        return view('lecture.create', compact('courses', 'subjects', 'course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureRequest $request)
    {
        $video = "";
        $video_40s = "";
        $video_name = "";
        // MARK: - save video
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $originalFileName = $request->file('video')->getClientOriginalName();
            $video_name = "lecture_video_". time() . '.' . $request->file('video')->extension();
            $video = $file->storeAs('course_video', $video_name, 'public');
            $video_40s = "lecture_video_segment/$video_name";

            Storage::makeDirectory('public/lecture_video_segment');
            $this->splitVideo($video_name);
        }

        $lecture = Lecture::create([
            'admin_id'          => Auth::guard('admin')->user()->id, 
            'subject_id'        => $request->subject_id, 
            'course_id'         => $request->course_id, 
            'video'             => $video, 
            'video_40s'         => $video_40s, 
            'video_name'        => $video_name, 
            'title'             => $request->title, 
            'description'       => $request->description, 
            'duration'          => $request->duration, 
            'size'              => $request->size, 
            'order'             => $request->order, 
        ]);

        return redirect()->route( 'lecture.index', 'course_id='.$request->course_id );
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecture $lecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $lecture)
    {
        $courses = Course::get();
        $subjects = Subject::get();

        return view('lecture.edit', compact('courses', 'subjects', 'lecture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        // MARK: - save video
        if ($request->hasFile('video')) {

            Storage::delete("public/".$lecture->video);
            Storage::delete("public/".$lecture->video_40s);

            $file = $request->file('video');
            $originalFileName = $request->file('video')->getClientOriginalName();
            $video_name = "lecture_video_". time() . '.' . $request->file('video')->extension();
            $video = $file->storeAs('lecture_video', $video_name, 'public');
            $video_40s = "lecture_video_segment/$video_name";

            Storage::makeDirectory('public/lecture_video_segment');
            $this->splitVideo($video_name);

            $lecture->video      = $video;
            $lecture->video_name = $video_name;
            $lecture->video_40s  = $video_40s;
        }


        $lecture->subject_id    = $request->subject_id;
        $lecture->course_id     = $request->course_id;
        $lecture->title         = $request->title;
        $lecture->description   = $request->description;
        $lecture->duration      = $request->duration;
        $lecture->size          = $request->size;
        $lecture->order         = $request->order;
        $lecture->save();

        return redirect()->route('lecture.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        //
    }



        // MARK: - FFMpeg
        public function splitVideo($filename)
        {
            try {
                $start = 0; // Start time in seconds
                $end = 40; // End time in seconds
        
                // Set output file name
                $inputVideoPath = storage_path("app/public/lecture_video/$filename");
                $outputFilePath = storage_path("app/public/lecture_video_segment/$filename");
        
                // Execute FFmpeg command to segment the video
                $result = Process::run("ffmpeg -i $inputVideoPath -ss $start -to $end -c copy $outputFilePath");
                Log::debug(["ffmpeg command => ", "ffmpeg -i $inputVideoPath -ss $start -to $end -c copy $outputFilePath"]);
                return $result->output();
            } catch (\Throwable $th) {
                //throw $th;
            }
           
        }
}
