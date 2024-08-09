<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Admin;

use Auth;
use DB;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teachers = Admin::where('role', 'Teacher');

        if($request->query("name")) {
            $paramName = $request->query('name');
            $teachers = $teachers->whereRaw(DB::raw("CONCAT(first_name, ' ', last_name) LIKE '%".$paramName."%'"));
        }

        if($request->query("email")) {
            $teachers = $teachers->where('email', "LIKE", "%".$request->query('email')."%");
        }

        if($request->query("phone")) {
            $teachers = $teachers->where('phone', "LIKE", "%".$request->query('phone')."%");
        }

        if($request->query("activated")) {
            $teachers = $teachers->where('activated', $request->query('activated'));
        }

        $teachers = $teachers->get();

        return view('teacher.index', compact('teachers'));
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
    public function edit(Admin $admin)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $account)
    {
        $account->decrease = $request->decrease;
        $account->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // MARK: - Update Profile
    public function updateProfile(Request $request)
    {

        request()->validate([
            'first_name'        => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255'],
            'phone'             => ['required'],
        ], app("messages"));

        $admin = Auth::guard('admin')->user();

        $avatar_path = "";

        if ($request->hasFile('file')) {
            $fileValidator = Validator::make($request->all(), [
                'file' => 'file|mimes:png,jpg,jpeg',
            ]);
            if ($fileValidator->fails()) {
                $errors = $fileValidator->errors();
                return back()->withErrors($fileValidator);
            }
            $file = $request->file('file');
            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = auth()->guard('admin')->user()->id . time() . '.' . $request->file('file')->extension();
            // $path = $file->storeAs('avatars', $filename, 'public');

            // MARK: #Resize the image
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
            $storagePath = storage_path('app/public/avatars');
            $encoded->save($storagePath . '/' . $filename);

            $avatar_path = '/storage/avatars/' . $filename;
            $admin->avatar          = $avatar_path;
        }


        $admin->email           = $request->email;
        $admin->first_name      = $request->first_name;
        $admin->last_name       = isset($request->last_name) ? $request->last_name : "";
        $admin->phone           = $request->phone;
        $admin->stripe_api_key  = isset($request->stripe_api_key) ? $request->stripe_api_key : "";
        $admin->he_name         = isset($request->he_name) ? $request->he_name : "";
        $admin->ar_name         = isset($request->ar_name) ? $request->ar_name : "";

        $admin->save();


        return back()->with('success', 'Profile update success.');
    }


    public function setActive(Request $request, Admin $account) 
    {
        $account->activated = $request->state;
        $account->save();

        return redirect()->back();
    }
}
