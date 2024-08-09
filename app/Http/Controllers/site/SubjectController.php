<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use App\Models\Subject;
use App\Models\Admin;

use Auth;
use DB;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subjects = Subject::where('id', '>', 0);

        if( Auth::guard('admin')->user()->role == Admin::$ROLE_TEACHER )
        {
            $subjects = $subjects->where('admin_id', Auth::guard('admin')->user()->id);
        }

        if($request->query("title")) {
            $subjects = $subjects->where('title', "LIKE", "%".$request->query('title')."%");
        }

        if($request->query("description")) {
            $subjects = $subjects->where('description', "LIKE", "%".$request->query('description')."%");
        }

        if($request->query("created_at")) {
            $subjects = $subjects->where('created_at', "LIKE", "%".$request->query('created_at')."%");
        }

        if($request->query("locale")) {
            $subjects = $subjects->where('locale', $request->query("locale"));
        }

        $teacher = $request->query("teacher");
        if($teacher) {
            $subjects = $subjects->with('admin')->whereHas('admin', function ($query) use ($teacher) {
                // Add additional conditions if needed
                $query->whereRaw(DB::Raw("CONCAT(first_name, ' ', last_name) LIKE '%$teacher%'"));
            });
        }

        $subjects = $subjects->get();

        return view('subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::get();
        return view('subject.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'file'          => 'required|file|mimes:png,jpg,jpeg',
        ]);

        $image_path = "";

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = auth()->guard('admin')->user()->id . time() . '.' . $request->file('file')->extension();
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
            Storage::makeDirectory('public/subjects');
            $storagePath = storage_path('app/public/subjects');
            $encoded->save($storagePath . '/' . $filename);

            $image_path = '/storage/subjects/' . $filename;
        }

        Subject::create([
            'title'         => $request->title, 
            'description'   => $request->description, 
            'image'         => $image_path, 
            'admin_id'      => Auth::guard('admin')->user()->id, 
            'locale'        => $request->locale
        ]);

        return redirect()->route('subject.index');
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
    public function edit(Subject $subject)
    {
        return view('subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        request()->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
        ]);

        $subject->title         = $request->title;
        $subject->description   = $request->description;
        $subject->locale        = $request->locale;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = auth()->guard('admin')->user()->id . time() . '.' . $request->file('file')->extension();
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
            Storage::makeDirectory('public/subjects');
            $storagePath = storage_path('app/public/subjects');
            $encoded->save($storagePath . '/' . $filename);

            $image_path = '/storage/subjects/' . $filename;
            $subject->image     = $image_path;

        }

        $subject->save();

        return redirect()->route('subject.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Subject $subject )
    {
        // return Storage::delete( storage_path('public/subjects/11714268966.png') );

        $subject->delete();

        return back()->with('status', 'Subject delete success.');
    }
}
