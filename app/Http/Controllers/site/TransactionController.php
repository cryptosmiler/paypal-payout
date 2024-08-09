<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\Request;

use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::query();

        if($request->query("transaction_id")) {
            $transactions = $transactions->where('transaction_id', $request->query('transaction_id'));
        }

        if($request->query("title")) {
            $transactions = $transactions->where('title', "LIKE", "%".$request->query('title')."%");
        }

        if($request->query("date")) {
            $transactions = $transactions->where('date', "LIKE", "%".$request->query('date')."%");
        }

        $user_name = $request->query("name");
        $user_email = $request->query("email");
        $user_phone = $request->query("phone");

        $transactions = $transactions->with('user')->whereHas('user', function ($query) use ($user_name, $user_email, $user_phone) {
            // Add additional conditions if needed
            if($user_name) {
                $query->whereRaw(DB::Raw("name LIKE '%$user_name%'"));
            }

            if($user_email) {
                $query->whereRaw(DB::Raw("email LIKE '%$user_email%'"));
            }

            if($user_phone) {
                $query->whereRaw(DB::Raw("CONCAT(phone_code, phone_number) LIKE '%$user_phone%'"));
            }
        });

        $transactions = $transactions->with('user')->orderBy('date', "DESC")->paginate(25);

        return view('transaction.index', compact('transactions'));
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
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
