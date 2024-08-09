<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $languages = Language::query();

        if($request->query('english'))
        {
            $languages = $languages->where('en', "LIKE", "%" . $request->query('english') . "%");
        }

        if($request->query('hebrew'))
        {
            $languages = $languages->where('he', "LIKE", "%" . $request->query('hebrew') . "%");
        }

        if($request->query('arabic'))
        {
            $languages = $languages->where('ar', "LIKE", "%" . $request->query('arabic') . "%");
        }

        if($request->query("type"))
        {
            $languages = $languages->where('type', $request->query("type"));
        }

        $languages = $languages->get();

        return view('language.index', compact('languages'));
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
    public function edit(Language $language)
    {
        return view('language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        request()->validate([
            'en'            => ['required', 'string'],
            'he'            => ['required', 'string'],
            'ar'            => ['required', 'string'],
        ]);

        $language->en   = $request->en;
        $language->ar   = $request->ar;
        $language->he   = $request->he;
        $language->save();

        return redirect()->route('language.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
