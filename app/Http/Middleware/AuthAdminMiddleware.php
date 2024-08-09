<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


class AuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('admin')->check())
        {
            return Redirect::route('login.show');
        } 
        else if (!Auth::guard('admin')->user()->phone_verified_at) {

            return Redirect::route('phone-verify-required.show');
        } 
        else {
            $user = Auth::guard('admin')->user();
            if( !$user->email_verified_at) {
                return Redirect::route('email-verify-required.show');
            }

            // Get current time
            $currentTime = Carbon::now();

            // Get updated_at time
            $updatedAtTime = Carbon::createFromFormat('Y-m-d H:i:s', $user->updated_at);

            // Check if updated_at time is within one day before current time
            if ($updatedAtTime->diffInMinutes($currentTime) <= 25) {
                // User verified within one day before, proceed with the request
                return $next($request);
            }
            $user->phone_verified_at = null;
            $user->save();

            return Redirect::route('login.show');
        }

        $admin = Auth::guard('admin')->user();
        $admin->updated_at = now();
        $admin->save();
        
        return $next($request);
    }
}
