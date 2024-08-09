<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Exports\LogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        Log::where('context->ip', '188.43.136.33')->delete();


        $logs = Log::query();

        if( $request->query('level') ) 
        {
            $logs = $logs->where('level', $request->query('level'));
        }

        if( $request->query('message') ) 
        {
            $logs = $logs->where('message', 'LIKE', "%".$request->query('message')."%");
        }

        if( $request->query('role') ) 
        {
            $logs = $logs->where('context->role', 'LIKE', "%".$request->query('role')."%");
        }

        if( $request->query('name') ) 
        {
            $logs = $logs->where('context->name', 'LIKE', "%".$request->query('name')."%");
        }

        if( $request->query('email') ) 
        {
            $logs = $logs->where('context->email', 'LIKE', "%".$request->query('email')."%");
        }

        if( $request->query('phone') ) 
        {
            $logs = $logs->where('context->phone', 'LIKE', "%".$request->query('phone')."%");
        }

        if( $request->query('ip') ) 
        {
            $logs = $logs->where('context->ip', 'LIKE', "%".$request->query('ip')."%");
        }

        if( $request->query('start') )
        {
            $logs = $logs->where('created_at', '>', $request->query('start'));
        }


        if( $request->query('end') )
        {
            $logs = $logs->where('created_at', '<', $request->query('end') . " 23:59:59");
        }


        $logs = $logs->orderBy('created_at', "DESC")->paginate(25);

        return view('log.index', compact('logs'));
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
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        $log->delete();

        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new LogsExport, 'logs_'.date('Y_m_d__H_i_s', time()).'.xlsx');
    }

    public function deleteall(Request $request)
    {
        $rules = [
            'start' => 'required|date',
            'end'   => 'required|date',
            //Additional rules go here
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        Log::whereBetween('created_at', [$request->start, $request->end. " 23:59:59"])->delete();

        return redirect()->back();
    }
}
