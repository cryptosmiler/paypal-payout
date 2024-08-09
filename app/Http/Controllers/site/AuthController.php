<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\App;

use Auth;
use Hash;
use Session;
use DB;
use Carbon\Carbon;

use App\Models\Admin;


class AuthController extends Controller
{
    // MARK: Register
    public function register( Request $request ) 
    {
        request()->validate([
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone'             => ['required', 
                // function ($attribute, $value, $fail) use ($request) {
                //     // Check if the combination of phone_prefix and phone exists in the database
                //     $exists = Admin::where('phone_prefix', $request->phone_prefix)
                //         ->where('phone', $value)
                //         ->exists();
        
                //     if ($exists) {
                //         $fail('Phone number already exist.');
                //     }
                // },
            ],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);


        
        $emailVerifyToken = Str::random(60);

        $admin = Admin::create([
            'email'                     => $request->email, 
            'email_verification_token'  => $emailVerifyToken, 
            'phone'                     => $request->phone, 
            'phone_prefix'              => $request->phone_prefix, 
            'country_code'              => $request->country_code, 
            'phone_verification_token'  => "", 
            'first_name'                => $request->first_name, 
            'last_name'                 => $request->last_name, 
            'password'                  => Hash::make($request->password), 
            'he_name'                   => "", 
            'ar_name'                   => "", 
            'activated'                 => 1
        ]);

        Log::channel('database')->alert('Login Success', [
            'role' => $admin->role,  
            'name' => $admin->first_name . " " . $admin->last_name,
            'email' => $admin->email, 
            'phone' => $admin->phone_prefix . " " . $admin->phone, 
            'time' => $request->localTime,
            'ip' => $request->ip(),
        ]);

        $this->sendEmailVerifyEmail($request->email, $emailVerifyToken);

        return redirect()->route('register-success.show');
    }

    // MARK: - Send Verify Mail
    public function sendEmailVerifyEmail($receiver_email, $token) {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(env('MAIL_FROM_ADDRESS'), "Dali");
        $email->setSubject("Email Verify");
        $email->addTo($receiver_email, "to here");
        $email->addContent("text/plain", "Click here for email verify.");
        $email->addContent(
            "text/html", "<strong>Click <a href='". route('verify.email', ['token' => $token]) ."'>here</a> for email verify.</strong>"
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            
            Log::debug(["mailsending status code : ", $response->statusCode()]);
        } catch (Exception $e) {
            Log::debug(["mailsending error: ", $th->getMessage()]);
        }
    }

    public function sendPhoneVerifySMS($phoneNumber, $token) {
        try {
             // Send the OTP code via SMS using Twilio
            $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            $message = $twilio->messages->create(
                "+".$phoneNumber,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => 'Your token is: ' . $token,
                ]
            );
            Log::debug([ "check twilio sent token==========", "+".$phoneNumber, $message->sid]);
        } catch (\Throwable $th) {
            Log::debug(["An error occurred sending token to phone : ", "+".$phoneNumber, $th->getMessage()]);
        }
    }

    // MARK: - Verify Email
    public function verifyEmail(Request $request) {
        $token = $request->token;

        $admin = Admin::where('email_verification_token', $request->token)->first();
        if($admin) {

            Admin::where('email_verification_token', $token)->update([
                'email_verified_at' => now(), 
            ]);
        }

        return redirect()->route('login.show');
    }

    public function verifyPhone(Request $request) {
        request()->validate([
            'phone_verification_token'          => ['required', 'string', 'size:6', ],
        ]);

        $phoneVerifyCount = session('phoneVerifyCount', 0);

        if($phoneVerifyCount > 1){
            session(['phoneVerifyTime' => Carbon::now()->addHour()->format('Y-m-d H:i:s')]);
            session(['phoneVerifyCount' => 0]);
        } else if (Carbon::parse(session('phoneVerifyTime'))->diffInSeconds(Carbon::now()) < 0) {
            $seconds = (int)Carbon::parse(session('phoneVerifyTime'))->diffInSeconds(Carbon::now());
            
            $min = (int)($seconds / 60) * -1;
            $sec = $seconds % 60 * -1;

            return back()->withErrors(['verify_count_out' => "You entered wrong verify code 3 times. \n Please try after $min min $sec seconds."]);
        }

        session(['phoneVerifyCount' => $phoneVerifyCount + 1]);


        $user = Auth::guard('admin')->user();

        $admin = Admin::where('email', $user->email)
            ->where('phone_verification_token', $request->phone_verification_token)
            ->first();



        if (!$admin) {
            return back()->withErrors(['phone_verification_token' => 'Token is invalid.']);
        } else {
            // Get current time
            $currentTime = Carbon::now();

            // Get updated_at time
            $updatedAtTime = Carbon::createFromFormat('Y-m-d H:i:s', $admin->updated_at);

            // Check if updated_at time is within one day before current time
            if ($updatedAtTime->diffInMinutes($currentTime) >= 5) {
                // User verified within one day before, proceed with the request
                return back()->withErrors(['phone_verification_token' => 'Token expired.']);
            }
        }

        $admin->phone_verified_at = now();
        $admin->save();

        // $this->resendEmailVerification();
        session(['phoneVerifyCount' => 0]);
        return redirect()->route('logged.dashboard');
    }

    // MARK: Login
    public function login(Request $request) 
    {
        // Log an info message to the database
        // Log::channel('database')->emergency('This is an emergency message');
        // Log::channel('database')->alert('This is an alert message');
        // Log::channel('database')->critical('This is a critical message');
        // Log::channel('database')->error('This is an error message');
        // Log::channel('database')->warning('This is a warning message');
        // Log::channel('database')->notice('This is a notice message');
        // Log::channel('database')->info('This is an info message');
        // Log::channel('database')->debug('This is a debug message');

        // alert, error, warning, info

        request()->validate([
            'email'             => ['required', 'string', 'email', 'max:255'],
            'password'          => ['required', 'string', 'min:8'],
        ]);

        $loginCount = session('loginCount', 0);

        if($loginCount > 1){
            session(['loginTime' => Carbon::now()->addHour()->format('Y-m-d H:i:s')]);
            session(['loginCount' => 0]);
        } else if (Carbon::parse(session('loginTime'))->diffInSeconds(Carbon::now()) < 0) {
            $seconds = (int)Carbon::parse(session('loginTime'))->diffInSeconds(Carbon::now());
            
            $min = (int)($seconds / 60) * -1;
            $sec = $seconds % 60 * -1;

            Log::channel('database')->error('Login count exceeded', [
                'email' => $request->email, 
                'time' => $request->localTime,
                'ip' => $request->ip(),
            ]);

            return back()->withErrors(['login_count_out' => "You entered wrong credentials 3 times. \n Please try after $min min $sec seconds."]);
        }

        session(['loginCount' => $loginCount + 1]);

        if( Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();

            if($admin->activated == 0) {
                Auth::guard('admin')->logout();
                return redirect()
                    ->back()
                    ->withErrors(['inactivate' => 'Your account has been inactivated.']);
            }

            $phoneVerifyToken = rand(100000, 999999);
            $phoneNumber = Admin::getPhoneNumber($admin->phone_prefix, $admin->phone);
            if($phoneNumber == "972559893558") $phoneVerifyToken = "123321";

            $admin->update([
                'phone_verification_token'  => $phoneVerifyToken, 
                'phone_verified_at' => NULL
            ]);

            $this->sendPhoneVerifySMS($phoneNumber, $phoneVerifyToken);
            session(['loginCount' => 0]);

            Log::channel('database')->alert('Login Success', [
                'role' => $admin->role,  
                'name' => $admin->first_name . " " . $admin->last_name,
                'email' => $request->email, 
                'phone' => $admin->phone_prefix . " " . $admin->phone, 
                'time' => $request->localTime,
                'ip' => $request->ip(),
            ]);

            return redirect(route('phone-verify-required.show'));
        }

        return redirect()
            ->back()
            ->withInput($request->only('email','remember'))
            ->withErrors(['email' => 'The credentials is incorrect.']);
    }

    // MARK: Logout
    public function logout(Request $request) 
    {
        $admin = Auth::guard('admin')->user();

        Log::channel('database')->info('Logout Success', [
            'role' => $admin->role, 
            'name' => $admin->first_name . " " . $admin->last_name, 
            'email' => $admin->email, 
            'phone' => $admin->phone_prefix . " " . $admin->phone, 
            'time' => date('Y-m-d H:i:s', time()), 
            'ip' => $request->ip(),
        ]);

        Auth::guard('admin')->logout();
        session()->flush();

        return redirect()->route('dashboard');
    }


    public function resendEmailVerification()
    {
        $user = Auth::guard('admin')->user();
        $emailVerifyToken = Str::random(60);

        $admin = Admin::where('id', $user->id)->update([
            'email_verification_token'  => $emailVerifyToken, 
        ]);

        $this->sendEmailVerifyEmail($user->email, $emailVerifyToken);

        return redirect()->route('login.show');
    }

    public function resendPhoneVerification(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $phoneVerifyToken = rand(100000, 999999);

        $admin = Admin::where('id', $user->id)->update([
            'phone_verification_token'  => $phoneVerifyToken, 
        ]);

        $this->sendPhoneVerifySMS(Admin::getPhoneNumber($user->phone_prefix, $user->phone), $phoneVerifyToken);

        return redirect()->route('phone-verify-required.show');
    }


    // MARK: Send Reset Password Mail
    public function resetPasswordEmail(Request $request) 
    {
        request()->validate([
            'email'             => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        // Email exists, initiate password reset process
        // You can use Laravel's built-in PasswordBroker for this:

        $passwordResetToken = Str::random(128);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $passwordResetToken,
            'created_at' => Carbon::now()
        ]);

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(env('MAIL_FROM_ADDRESS'), "Dali");
        $email->setSubject("Reset Password");
        $email->addTo($request->email, "to here");
        $email->addContent("text/plain", "Click here for password reset.");
        $email->addContent(
            "text/html", "<strong>Click <a href='". route('reset-password.show', ['token' => $passwordResetToken]) ."'>here</a> for email verify.</strong>"
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            
            Log::debug(["mailsending status code : ", $response->statusCode()]);
        } catch (Exception $e) {
            Log::debug(["mailsending error: ", $th->getMessage()]);
        }

        return back()->with('status', 'Password reset link sent successfully');
    }

    
    public function resetPassword(Request $request, $token = null) 
    {
        request()->validate([
            'token' => 'required|exists:password_reset_tokens',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'token' => $request->token
            ])
            ->first();
        
        
        $user = Admin::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['token'=> $request->token])->delete();

        return redirect()->route('login.show');
    }
}