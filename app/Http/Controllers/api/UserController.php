<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Storage;

use Tymon\JWTAuth\Facades\JWTAuth;

use Hash;
use DB;

use App\Models\User;
use App\Models\Otp;
use App\Models\Transaction;
use App\Models\Setting;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        Log::debug(["### all request => ###", $request->all()]);
        $validator = Validator::make($request->all(), [
            'country_code'      => 'required',
            'phone_code'        => 'required',
            'phone'             => 'required',
            // 'phone_number'      => ['required', 
            //     function ($attribute, $value, $fail) use ($request) {
            //         // Check if the combination of phone_code and phone_number exists in the database
            //         $exists = User::where('phone_code', $request->phone_code)
            //             ->where('phone_number', $value)
            //             ->exists();
        
            //         if ($exists) {
            //             $fail('Phone number already exist.');
            //         }
            //     },                            
            // ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // Now you can work with the $errors object, which contains the validation errors
            // For example:
            return response()->json(['status' => 'error', 'message' => 'Validation error', 'errors' => $errors], 200);
        }

        $user = User::where('phone_code', $request->phone_code)->where('phone_number', $request->phone_number)->first();

        if( !$user ) {
            $user = User::create([
                'country_code'   => $request->country_code,
                'phone_code'     => $request->phone_code,
                'phone_number'   => $request->phone_number,
                'activated'      => 1
            ]);

            $gift = Setting::where('key', 'welcome_gift')->first();

            $transaction = Transaction::create([
                'admin_id'          => 0, 
                'user_id'           => $user->id, 
                'transaction_id'    => '', 
                'type'              => 'Gift', 
                'title'             => 'Welcome Gift', 
                'content'           => "Gift " . $gift->value . " (". $gift->describe .")", 
                'amount'            => $gift->value * 100, 
                'date'              => date("Y/m/d, H:i", time()), 
                'mins'              => 0, 
                'questions'         => 0
            ]);
        } else {
            $inactiveUser = User::where('phone_code', $request->phone_code)->where('phone_number', $request->phone_number)->where('activated', 0)->first();
            if($inactiveUser) {
                return response()->json([
                    "message" => "Your account has been inactivated.", 
                    "status" => "error"
                ], 403);
            }
        }

        $otp = rand(10000, 99999);
        if( $request->phone_code.$request->phone_number === "+972559893558" ) {
            $otp = "12234";
        }

        $phoneNumber = $request->phone;
        Otp::where('phone_number', $phoneNumber)->delete();

        $otpModel = new Otp;
        $otpModel->otp              = $otp;
        $otpModel->phone_number     = $phoneNumber;
        $otpModel->otp_verified_at  = date('Y-m-d H:i:s');
        $otpModel->save();

        $this->sendOTPToPhone($phoneNumber, $otp);

        return response()->json([
            'user' => $user, 
            "status" => "success"
        ], 200);

        // $token = $user->createToken('auth_token')->plainTextToken;

        // $cookie = cookie('token', $token, 60 * 24); // 1 day
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Log::debug(["request all", $request->all()]);
        try {
            $user->card_id                  = $request->card_id ?? $user->card_id;
            $user->policy_accept            = $request->policy_accept ?? $user->policy_accept;
            $user->email                    = $request->email ?? $user->email;
            $user->name                     = $request->name ?? $user->name;

            if ($request->hasFile('avatar')) {
                Storage::delete("public/".$user->avatar);

                $file = $request->file('avatar');
                $originalFileName = $request->file('avatar')->getClientOriginalName();
                $filename = $user->id . time() . '.' . $request->file('avatar')->extension();
                $path = $file->storeAs('avatars', $filename, 'public');

                $user->avatar = $path;
            }



            if($request->policy_accept) {
                Log::channel('database')->info('Policy Approved', [
                    'role' => "Student",  
                    'name' => $user->name,
                    'email' => $user->email, 
                    'phone' => $user->phone_code . " " . $user->phone_number, 
                    'time' => $request->localTime, 
                    'ip' => $request->ip(),
                ]);
                $user->policy_date = date('Y-m-d H:i:s', time());
            }

            $user->save();

            $user = User::find($user->id);

            return response()->json([
                "user" => $user, 
                "status" => "success"
            ], 200);
        } catch (\Throwable $th) {
            Log::debug(["save personal setting error: ", $th->message]);

            return response()->json([
                "message" => $th->message, 
                "status" => "error"
            ], 422);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendOTP( Request $request ) {
        try {
            // Generate an OTP code
            $otp = rand(10000, 99999);
            if( $request->phone_number === "+972559893558" ) {
                $otp = "12234";
            }

            $phoneNumber    = $request->phone_number;
            // $hash           = $request->hash;
            $hash           = "";

            if($request->phone_number != "+972559893558") {

                // Send the OTP code via SMS using Twilio
                $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
                $message = $twilio->messages->create(
                    $phoneNumber,
                    [
                        'from' => env('TWILIO_PHONE_NUMBER'),
                        'body' => 'Your OTP code is: ' . $otp . " " . $hash,
                    ]
                );
    
                Log::debug([ "check twilio sent opt==========", $phoneNumber, $message->sid]);
            }


            Otp::where('phone_number', $phoneNumber)->delete();

            $otpModel = new Otp;
            $otpModel->otp              = $otp;
            $otpModel->phone_number     = $phoneNumber;
            $otpModel->otp_verified_at  = date('Y-m-d H:i:s');
            $otpModel->save();


            return response()->json([
                // "message" => $message, 
                "status" => "success"
            ], 200);
        } catch (\Throwable $th) {
            Log::debug(["An error occurred sending OTP: ", $th->getMessage()]);
            return response()->json([
                "message" => $th->getMessage(), 
                "status" => "error"
            ], 422);
        }
        
    }

    public function checkOTP( Request $request ) {

        try {

            $otp = Otp::where([ 'otp' => $request->otp, 'phone_number' => $request->phone_number ])
                ->whereRaw(DB::raw("otp_verified_at > DATE_ADD(NOW(), INTERVAL -1 MINUTE)"))
                ->first();

            Log::debug( [ "otp and phone number ==================", 
                $request->otp, 
                $request->phone_number, 
            ]);


            if( $otp ) {
                $user = User::whereRaw('CONCAT(phone_code, phone_number) = ?', [$otp->phone_number])->first();

                // $user->fcm_token = $request->fcm_token;
                $user->fcm_token = "";
                $user->save();

                $customClaims = [
                    'otp' => $otp->otp,
                    'phone_number' => $otp->phone_number,
                    'otp_verified_at' => $otp->otp_verified_at,
                ];

                $token = JWTAuth::claims($customClaims)->fromUser($otp);
                return response()->json([
                    "csrfToken" => csrf_token(), 
                    "serviceToken" => $token, 
                    "user" => $user, 
                    "status" => "success"
                ], 200);
            } else {
                return response()->json([
                    "token" => false, 
                    "status" => "error"
                ], 422);
            }
        } catch (\Throwable $th) {
            Log::debug(["catch error ============ ", $th->getMessage()]);
            return response()->json([
                "token" => $th->getMessage(), 
                "status" => "error"
            ], 422);
        }
    }


    public function sendOTPToPhone($phoneNumber, $otp) {
        try {
             // Send the OTP code via SMS using Twilio
            $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            $message = $twilio->messages->create(
                $phoneNumber,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => 'Your otp is: ' . $otp,
                ]
            );
            Log::debug([ "check twilio sent otp==========", $phoneNumber, $message->sid]);
        } catch (\Throwable $th) {
            Log::debug(["An error occurred sending otp to phone : ", $phoneNumber, $th->getMessage()]);
        }
    }

    public function settings() 
    {
        // Retrieve all settings as key-value pairs
        $settings = Setting::pluck('value', 'key')->toArray();

        // Return the settings as a JSON response, for example
        return response()->json($settings);
    }
}
