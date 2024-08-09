<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Admin;
use App\Models\Lecture;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Auth;

use Illuminate\Support\Facades\Process;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::where('id', '>', 0);
        $subjects = Subject::get();

        if( Auth::guard('admin')->user()->role == Admin::$ROLE_TEACHER ) {
            $courses = $courses->where('admin_id', Auth::guard('admin')->user()->id)->where('status', 'created');

            $subjects = Subject::where('admin_id', Auth::guard('admin')->user()->id);
        }

        if($request->query("title")) {
            $courses = $courses->where('title', "LIKE", "%".$request->query('title')."%");
        }

        if($request->query("subject_id")) {
            $courses = $courses->where('subject_id', "LIKE", "%".$request->query('subject_id')."%");
        }

        $teacher = $request->query("teacher");
        if($teacher) {
            $courses = $courses->with('admin')->whereHas('admin', function ($query) use ($teacher) {
                // Add additional conditions if needed
                $query->whereRaw(DB::Raw("CONCAT(first_name, ' ', last_name) LIKE '%$teacher%'"));
            });
        }

        if($request->query("coupon")) {
            $courses = $courses->where('coupon', "LIKE", "%".$request->query('coupon')."%");
        }

        if($request->query("visible")) {
            $courses = $courses->where('visible', "LIKE", "%".$request->query('visible')."%");
        }

        if($request->query("status")) {
            $courses = $courses->where('status', $request->query('status'));
        }

        $courses = $courses
            ->orderBy("order")
            ->with(['admin', 'subject'])
            ->withCount([
                'lectures' => function ($query) {
                    $query->where('status', 'created');
                }
            ])
            ->get();

        return view('course.index', compact('courses', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::get();

        return view('course.create', compact('subjects'));
    }

    // MARK: - --- STORE COURSE ---
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $image_path = "";

        // MARK: - save image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalFileName = $request->file('image')->getClientOriginalName();
            $filename = auth()->guard('admin')->user()->id . time() . '.' . $request->file('image')->extension();
            // $path = $file->storeAs('avatars', $filename, 'public');

            // resize image
            $manager = new ImageManager(new Driver());

            $image = $manager->read( $file );
            $size = $image->size();
            $width = $size[1]->x();
            $height = $size[2]->y();
            $rate = $height / 300;

            $image->resize($width / $rate * -1, 300);

            // encode edited image
            $encoded = $image->toJpg();

            // save encoded image
            Storage::makeDirectory('public/course_image');
            $storagePath = storage_path('app/public/course_image');
            $encoded->save($storagePath . '/' . $filename);

            $image_path = '/storage/course_image/' . $filename;
        }

        $course = Course::create([
            'admin_id'          => Auth::guard('admin')->user()->id, 
            'subject_id'        => $request->subject_id, 
            'title'             => $request->title,
            'description'       => $request->description, 
            'image'             => $image_path, 
            'coupon'            => $request->coupon, 
            'visible'           => isset($request->visible) ? 'show' : 'hide', 
            'charge'            => isset($request->charge) ? 'free' : 'pay', 
            'video_price'       => $request->video_price ?? 0, 
            'question_price'    => $request->question_price ?? 0, 
            'status'            => 'created', 
            'order'             => $request->order, 
        ]);

        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $lectures = Lecture::where('course_id', $course->id)
            ->where('status', 'created')
            ->withCount([
                'questions' => function ($query) {
                    $query->where('status', 'created');
                }
            ])
            ->get();

        return view('course.show', compact('lectures'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $subjects = Subject::get();

        return view('course.edit', compact('course', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        // MARK: - save image
        if ($request->hasFile('image')) {
            Storage::delete("public/".$course->image);

            $file = $request->file('image');
            $originalFileName = $request->file('image')->getClientOriginalName();
            $filename = auth()->guard('admin')->user()->id . time() . '.' . $request->file('image')->extension();
            // $path = $file->storeAs('avatars', $filename, 'public');

            // resize image
            $manager = new ImageManager(new Driver());

            $image = $manager->read( $file );
            $size = $image->size();
            $width = $size[1]->x();
            $height = $size[2]->y();
            $rate = $height / 300;

            $image->resize($width / $rate * -1, 300);

            // encode edited image
            $encoded = $image->toJpg();

            // save encoded image
            Storage::makeDirectory('public/course_image');
            $storagePath = storage_path('app/public/course_image');
            $encoded->save($storagePath . '/' . $filename);

            $image_path = '/storage/course_image/' . $filename;

            $course->image = $image_path;

        }


        $course->subject_id     = $request->subject_id;
        $course->title          = $request->title;
        $course->description    = $request->description;
        $course->coupon         = $request->coupon;
        $course->visible        = isset($request->visible) ? 'show' : 'hide';
        $course->charge         = isset($request->charge) ? 'free' : 'pay';
        $course->video_price    = $request->video_price ?? 0;
        $course->question_price = $request->question_price ?? 0;
        $course->order          = $request->order;
        $course->save();

        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->status = "deleted";
        $course->save();

        return redirect()->back();
    }
}