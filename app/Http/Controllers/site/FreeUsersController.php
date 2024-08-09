<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FreeUser;
use App\Models\Admin;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;

use App\Imports\FreeUserImport;
use App\Exports\FreeUserExport;

use Auth;
use DB;

class FreeUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( Auth::guard('admin')->user()->role === Admin::$ROLE_TEACHER ) {
            $freeUsers = FreeUser::where('admin_id', Auth::guard('admin')->user()->id)->get();
            return view('freeuser.index', compact('freeUsers'));
        }

        $freeUsers = FreeUser::select(
                "subject_id", 
                "course_id", 
                "lecture_id", 
                "admin_id", 
                DB::Raw("MAX(id) as id"), 
                DB::Raw("COUNT(id) as counts"), 
            )->groupBy("subject_id", "course_id", "lecture_id", "admin_id")->get();
        
        return view('freeuser.index', compact('freeUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::get();
        $subjects = Subject::get();
        $lectures = Lecture::get();

        return view('freeuser.create', compact('courses', 'subjects', 'lectures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'subject_id'    => ['required'], 
            'course_id'     => ['required'], 
            'lecture_id'    => ['required'], 
            'phone'         => ['required', 'string'],
            'phone_prefix'  => ['required', 'string'],
        ]);

        $freeUser = FreeUser::create([
            'subject_id'    => $request->subject_id, 
            'course_id'     => $request->course_id, 
            'lecture_id'    => $request->lecture_id, 
            'admin_id'      => Auth::guard('admin')->user()->id,
            'phone'         => request('phone'),
            'phone_prefix'  => request('phone_prefix'),
        ]);

        return redirect()->route('freeUser.index')->with('success', 'Free User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FreeUser $freeUser)
    {
        $freeUsers = FreeUser::where('admin_id', $freeUser->admin_id)
            ->where('subject_id', $freeUser->subject_id)
            ->where('course_id', $freeUser->course_id)
            ->where('lecture_id', $freeUser->lecture_id)
            ->get();

        $subject_id = $freeUser->subject_id;
        $course_id = $freeUser->course_id;
        $lecture_id = $freeUser->lecture_id;

        return view('freeuser.show', compact('freeUsers', 'subject_id', 'course_id', 'lecture_id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FreeUser $freeUser)
    {
        return view('freeuser.edit', compact('freeUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FreeUser $freeUser)
    {
        request()->validate([
            'phone'         => ['required', 'string'],
            'phone_prefix'  => ['required', 'string'],
        ]);

        $freeUser->phone         = $request->phone;
        $freeUser->phone_prefix  = $request->phone_prefix;
        $freeUser->save();

        return redirect()->route('freeUser.index')->with('success', 'Free User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FreeUser $freeUser)
    {
        $freeUser->delete();

        return redirect()->route('freeUser.index')->with('success', 'Free User deleted successfully');
    }

    public function excelDownload(Request $request) 
    {
        return Excel::download(new FreeUserExport($request->subject_id, $request->course_id, $request->lecture_id, Auth::guard('admin')->user()->id), 'freeusers.xlsx');
    }

    public function excelUpload(Request $request) 
    {
        $file = $request->file('excel_file');

        // Assuming you're using Maatwebsite\Excel for importing
        $import = new FreeUserImport($request->subject_id, $request->course_id, $request->lecture_id, Auth::guard('admin')->user()->id);
        Excel::import($import, $file);

        return redirect()->back()->with('success', 'Excel data imported successfully.');
    }
}
