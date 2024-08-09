<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use DB;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'promo_title', 
        'date', 
        'promo_code', 
    ];

    
    /**
     * Checks if the promo code associated with this coupon has been used.
     *
     * @return bool True if the promo code has been used, false otherwise.
     */
    public function isPromoCodeUsed()
    {
        return DB::table('courses')->where('coupon', $this->promo_code)->exists();
    }
}
