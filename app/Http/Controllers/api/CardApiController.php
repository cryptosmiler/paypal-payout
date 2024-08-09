<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Braintree\Gateway;

class CardApiController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cards = Card::where('user_id', $request->user_id)->get();

        return response()->json([
            "status" => "success", 
            "cards" => $cards
        ], 200);
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
        $rules = [
            'card_name'         => 'required|string',
            'expiry_date'       => 'required|string',
            'cvv'               => 'required|string',
            'card_number'       => 'required|string',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error", 
                "message" => $validator->errors()->first()
            ], 400);
        }


        if( $request->card_id ) {
            $card = Card::find($request->card_id)->update([
                'card_name'     => $request->card_name, 
                'expiry_date'   => $request->expiry_date, 
                'cvv'           => $request->cvv, 
                'card_number'   => $request->card_number
            ]);
        } else {
            $user = User::find($request->user_id);

            $result = $this->gateway->customer()->create([
                'firstName' => $user->name,
                'company' => 'Jones Co.',
                'email' => $user->email,
                'phone' => $user->phone_code.$user->phone_number,
            ]);

            $card = Card::create([
                'user_id'       => $request->user_id, 
                'card_name'     => $request->card_name, 
                'expiry_date'   => $request->expiry_date, 
                'cvv'           => $request->cvv, 
                'card_number'   => $request->card_number, 
                'customer_id'   => $result->customer->id
            ]);
        }

        return response()->json([
            "status" => "success", 
            "card" => $card
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $cardApi)
    {
        return response()->json([
            "status" => "success", 
            "card" => $cardApi
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $cardApi)
    {
        $cardApi->delete();

        return response()->json([
            "status" => "success", 
        ], 200);
    }
}
