<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\TeacherTransaction;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use DB;

class TeacherTransactionController extends Controller
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;


    public function __construct()
    {
        $this->baseUrl = env('PAYPAL_LIVE_BASE_URL');
        $this->clientId = env('PAYPAL_LIVE_CLIENT_ID');
        $this->clientSecret = env('PAYPAL_LIVE_CLIENT_SECRET');
    }

    protected function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)->post("{$this->baseUrl}/v1/oauth2/token", [
            'grant_type' => 'client_credentials',
            // 'scope' => 'https://uri.paypal.com/services/payouts'
        ]);

        Log::debug(["accessToken => ", $response->json()]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        } else {
            throw new \Exception('Failed to obtain access token: ' . $response->body());
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacherTransactions = TeacherTransaction::with('teacher')->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                'admin_id',
                DB::raw('SUM(amount) as total_amount'), 
                DB::raw('max(id) as id'), 
            )
            ->groupBy('year', 'month', 'admin_id')
            ->orderBy('completed_date')
            ->paginate(25);

        return view('teacherTransaction.index', compact('teacherTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teacher = request()->query('teacher');
        $transferedMoneyAmount = TeacherTransaction::where( 'admin_id', $teacher )->sum('amount');
        return view('teacherTransaction.create', compact('transferedMoneyAmount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'amount'         => ['required', 'numeric', 'min:0'],
        ]);
        $accessToken = $this->getAccessToken();


        $admin_id = $request->admin_id;
        $amount = $request->amount;
        $currency = $request->input('currency', 'USD');
        $teacher = Admin::find($admin_id);

        if( !$teacher ) {
            return redirect()->back()->withErrors(['teacher' => 'Teacher not found']);
        }

        if( $teacher->stripe_api_key == "" ) {
            return redirect()->back()->withErrors(['teacher' => "The teacher did not register a PayPal email address."]);
        }

        $senderBatchId = Str::uuid(); // Generates a unique UUID for sender_batch_id
        $senderItemId = Str::uuid();  // Generates a unique UUID for sender_item_id

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post($this->baseUrl . '/v1/payments/payouts', [
            'sender_batch_header' => [
                'sender_batch_id' => $senderBatchId,
                'email_subject' => 'You have a payout!',
                'email_message' => 'You have received a payout! Thanks for using our service!'
            ],
            'items' => [
                [
                    'recipient_type' => 'EMAIL',
                    'amount' => [
                        'value' => $amount,
                        'currency' => $currency
                    ],
                    'note' => 'Thanks for your patronage!',
                    'sender_item_id' => $senderItemId,
                    'receiver' => $teacher->stripe_api_key,
                    'notification_language' => 'en-US', 
                    'purpose' => 'GOODS'
                ]
            ]
        ]);


        if ($response->successful()) {
            return response()->json(['status' => 'success', 'data' => $response->json()]);
        } else {
            return response()->json(['status' => 'error', 'data' => $response->json()], $response->status());
        }

        Log::debug($response->json());

        if ($response->successful()) {
            $response = $response->json();
            $payoutBatchId = $response['batch_header']['payout_batch_id'];
            $payoutBatchStatus = $response['batch_header']['batch_status'];

            TeacherTransaction::create([
                'admin_id' => $admin_id,
                'amount' => $amount,
                'state' => 'PENDING',
                'create_date' => date('Y-m-d H:i:s'),
                'completed_date' => null,
                'payout_batch_id' => $payoutBatchId,
            ]);
            return redirect()->route('account.index')->with('success', 'Teacher transaction created successfully!');
        }

        return redirect()->back()->withErrors(['teacher' => 'Failed to create teacher transaction']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherTransaction $teacherTransaction, Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $teacherTransactions = TeacherTransaction::with('teacher')
            ->where('admin_id', $teacherTransaction->admin_id)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('completed_date')
            ->paginate(25);
        return view('teacherTransaction.show', compact('teacherTransactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherTransaction $teacherTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherTransaction $teacherTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherTransaction $teacherTransaction)
    {
        //
    }

    public function download(Request $request)
    {

    }
}
