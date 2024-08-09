<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Otp extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'otp', 'phone_number'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'otp',
            'phone_number',
            'otp_verified_at'
        ]; // You can add custom claims if needed
    }
}
