<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\Lecture;
use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;
use Braintree\Gateway;
use Ramsey\Uuid\Uuid;

use Illuminate\Support\Facades\Log;

class TransactionApiController extends Controller
{

    protected $gateway;


    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;


    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;


        $this->baseUrl = env('PAYPAL_LIVE_BASE_URL');
        $this->clientId = env('PAYPAL_LIVE_CLIENT_ID');
        $this->clientSecret = env('PAYPAL_LIVE_CLIENT_SECRET');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', $request->user_id)->orderBy("date", "DESC")->get();

        $videoLectureCount = Transaction::where('user_id', $request->user_id)->sum('questions');
        $totalQuestionsCount = Transaction::where('user_id', $request->user_id)->sum('videos');
        $totalBalance = Transaction::where('user_id', $request->user_id)->sum('amount');

        return response()->json([
            "status" => "success", 
            "transactions" => $transactions, 
            "videoLectureCount" => $videoLectureCount, 
            "totalQuestionsCount" => $totalQuestionsCount, 
            "totalBalance" => $totalBalance, 
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $transactionType =  $request->type;
        if($transactionType == "Paid") {
        //     $amount = $request->input('amount');
        //     $nonce = $request->input('payment_method_nonce');
        //     $deviceData  = $request->input('device_data');

        //     $teacher = Admin::find($request->teacher_id);

        //     if( $teacher->stripe_api_key == "" ) {
        //         return response()->json(['status' => "error",]);    
        //     }
    
        //     $result = $this->gateway->transaction()->sale([
        //         'amount' => $amount,
        //         'paymentMethodNonce' => $nonce,
        //         'deviceData' => $deviceData,
        //         'options' => [
        //             'submitForSettlement' => false,
        //             'threeDSecure' => [
        //                 'required' => true
        //             ]
        //         ],
        //     ]);


        //     $this->gateway->transaction()->sale([
        //         'amount' => $amount * 0.3,
        //         'paymentMethodNonce' => $nonce,
        //         'merchantAccountId' => $teacher->stripe_api_key,
        //         'options' => [
        //             'submitForSettlement' => true,
        //         ],
        //     ]);

        //     return response()->json(['status' => "success",]);    
    
        //     if ($result->success) {
        //         Transaction::create([
        //             'admin_id'      => 0, 
        //             'user_id'       => $request->user_id, 
        //             'lecture_id'    => $request->lecture_id ?? 0, 
        //             'transaction_id'=> $result->transaction->id, 
        //             'type'          => $transactionType, 
        //             'title'         => $request->title, 
        //             'content'       => $request->content, 
        //             'amount'        => $amount * 100, 
        //             'date'          => date("Y/m/d, H:i", time()), 
        //         ]);
    
        //         $gift = Setting::where('key', $amount . '_bonus')->value('value');
    
        //         if( $gift > 0 ) {
        //             Transaction::create([
        //                 'admin_id'      => 0, 
        //                 'user_id'       => $request->user_id, 
        //                 'lecture_id'    => $request->lecture_id ?? 0, 
        //                 'transaction_id'=> $result->transaction->id, 
        //                 'type'          => "Gift", 
        //                 'title'         => "$" . $gift . " deposit gift", 
        //                 'content'       => "You got $" . $gift . " gift for $".$amount . " deposit", 
        //                 'amount'        => $gift * 100, 
        //                 'date'          => date("Y/m/d, H:i", time()), 
        //             ]);
        //         }
    
    
        //         return response()->json(['status' => "success", 'transaction_id' => $result->transaction->id]);
        //     } else {
        //         return response()->json(['status' => "error", 'message' => $result->message]);
        //     }
        } else {

            $amount = Transaction::where('user_id', $request->user_id)->sum("amount");
            if($amount < $request->amount * 100) {
                return response()->json(['status' => "error", 'message' => "There is insufficient balance."]);
            }


            Transaction::create([
                'admin_id'      => 0, 
                'user_id'       => $request->user_id, 
                'lecture_id'    => $request->lecture_id ?? 0, 
                'transaction_id'=> '', 
                'type'          => $transactionType, 
                'title'         => $request->title, 
                'content'       => $request->content, 
                'amount'        => ($request->amount ?? 0) * -100, 
                'date'          => date("Y/m/d, H:i", time()), 
                'videos'        => $request->videos ?? 0, 
                'mins'          => $request->mins ?? 0, 
                'questions'     => $request->questions ?? 0, 
                'question_ids'  => $request->question_ids ?? '[]', 
            ]);

            $course_id = $request->course_id;
            $user_id = $request->user_id;

            $lecture = Lecture::where('id', $request->lecture_id)            
                ->withCount([
                    'questions' => function ($query) {
                        $query->where('status', 'created');
                    }
                ])
                ->with([
                    'questions' => function ($query){
                        $query->where('status', 'created');
                    },
                    'course' => function ($query) use ($course_id, $user_id) {
                        $query->with(['transactions' => function ($query) use ($course_id, $user_id) {
                            $query->where([
                                'course_id' => $course_id, 
                                'user_id' => $user_id, 
                                'type' => "Promo Code", 
                            ]);
                        }]);
                    },
                    'transactions' => function ($query) use ($user_id) {
                        $query->where('user_id', $user_id);
                    }
                ])->first();

            return response()->json(['status' => "success", 'lecture' => $lecture]);
        }
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
    public function update(Request $request, Transaction $transaction)
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

    public function getToken(Request $request) 
    {
        try {
            $clientToken = $this->gateway->clientToken()->generate(['customerId' => $request->customer_id]);
            return response()->json(['clientToken' => $clientToken, 'status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 'error']);
        }
    }


    protected function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)->post("{$this->baseUrl}/v1/oauth2/token", [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        } else {
            throw new \Exception('Failed to obtain access token: ' . $response->body());
        }
    }

    function sendCurlRequest($url, $headers, $method = 'POST')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return ['error' => true, 'message' => $error_msg];
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    public function createOrder(Request $request)
    {

        $accessToken = $this->getAccessToken();

        Log::debug(["access Token", $accessToken]);

        try {
            $amount = $request->input('amount');
            $currency = $request->input('currency', 'USD');

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($this->baseUrl.'/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => $amount
                        ], 
                    ]
                ],
                "payment_source" => [
                    "paypal" => [
                        "experience_context" => [
                            "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
                            "brand_name" => "DEPOSIT WITH USD",
                            "locale" => "he-IL",
                            "landing_page" => "NO_PREFERENCE",
                            "shipping_preference" => "NO_SHIPPING",
                            "user_action" => "PAY_NOW",
                        ]
                    ]
                ]
            ]);
            Log::debug(["create order ", $response]);
            return $response['id'];
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'status' => 'error']);
        }
    }

    public function captureOrder(Request $request)
    {
        try {
            $accessToken = $this->getAccessToken();
            $orderId = $request->orderId;
            $paypalRequestId = Uuid::uuid4()->toString();


            $url = $this->baseUrl . '/v2/checkout/orders/' . $orderId . '/capture';
            $headers = [
                'Authorization: Bearer ' . $accessToken, 
                'Content-Type: application/json'
            ];

            $response = $this->sendCurlRequest($url, $headers);

            return $response;

        } catch (\Exception $e) {
            Log::error('Error capturing PayPal order', ['error' => $e->getMessage()]);
            throw $e;
        }
    }













    public function getGooglePayConfig()
    {
        // Example Google Pay configuration
        return response()->json([
            'apiVersion' => 2,
            'apiVersionMinor' => 0,
            'merchantInfo' => [
                'merchantId' => env('GOOGLE_PAY_MERCHANT_ID'), 
                'merchantName' => 'Dali',
            ],
            'allowedPaymentMethods' => [
                [
                    'type' => 'CARD',
                    'parameters' => [
                        'allowedAuthMethods' => ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                        'allowedCardNetworks' => ['VISA', 'MASTERCARD']
                    ],
                    'tokenizationSpecification' => [
                        'type' => 'PAYMENT_GATEWAY',
                        'parameters' => [
                            'gateway' => 'paypal',
                            'gatewayMerchantId' => env('PAYPAL_MERCHANT_ID')
                        ]
                    ]
                ]
            ]
        ]);
    }
}
