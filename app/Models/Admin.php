<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;

    public static $ROLE_SUPERADMIN  = "SuperAdmin";
    public static $ROLE_ADMIN       = "Admin";
    public static $ROLE_TEACHER     = "Teacher";


    protected $fillable = [
        'email', 
        'password', 
        'email_verification_token', 
        'email_verified_at', 
        'phone', 
        'phone_prefix', 
        'country_code', 
        'phone_verification_token', 
        'phone_verified_at', 
        'role', 
        'activated', 
        'first_name', 
        'last_name', 
        'stripe_api_key', 
        'avatar', 
        'he_name', 
        'ar_name', 
        'decrease'
    ];


    // Normalize phone numbers
    static function getPhoneNumber($prefix, $number)
    {
        // Remove non-numeric characters
        $number = preg_replace('/\D/', '', $number);

        // If the number starts with '0', remove it
        if (substr($number, 0, 1) === '0') {
            $number = substr($number, 1);
        }

        // Return normalized phone number
        return $prefix.$number;
    }

    public function isSuperAdmin()
    {
        
    }
}
