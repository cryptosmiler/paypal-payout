<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\LandingItem;
use App\Http\Requests\StoreLandingItemRequest;
use App\Http\Requests\UpdateLandingItemRequest;
use Illuminate\Support\Facades\Storage;

class LandingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $landingItems = LandingItem::get();

        return view('landingItem.index', compact('landingItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('landingItem.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLandingItemRequest $request)
    {
        $video = "";
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = "landingvideo_". time() . '.' . $request->file('file')->extension();
            $video = $file->storeAs('landingitem', $filename, 'public');
        }

        LandingItem::create([
            'type'          => $video == "" ? 'text': 'video', 
            'title'         => $request->title, 
            'description'   => $request->description, 
            'video'         => $video, 
            'image'         => '', 
            'order'         => $request->order, 
            'status'        => 'active', 
            'locale'        => $request->locale, 
        ]);

        return redirect()->route('landingItem.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LandingItem $landingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingItem $landingItem)
    {
        return view('landingItem.edit', compact('landingItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLandingItemRequest $request, LandingItem $landingItem)
    {
        $video = "";

        if ($request->hasFile('file')) {
            if($landingItem->video != "")
            {
                Storage::delete("public/".$landingItem->video);
            }

            $file = $request->file('file');
            $originalFileName = $request->file('file')->getClientOriginalName();
            $filename = "landingvideo_". time() . '.' . $request->file('file')->extension();
            $video = $file->storeAs('landingitem', $filename, 'public');
            $landingItem->video         = $video;
        }

        $landingItem->title         = $request->title;
        $landingItem->description   = $request->description;
        $landingItem->order         = $request->order;
        $landingItem->locale        = $request->locale;
        $landingItem->save();

        return redirect()->route('landingItem.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandingItem $landingItem)
    {
        if($landingItem->video != "")
        {
            Storage::delete("public/".$landingItem->video);
        }

        $landingItem->delete();

        return redirect()->back();
    }
}
