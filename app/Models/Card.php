<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'card_name', 
        'expiry_date', 
        'cvv', 
        'card_number', 
        'customer_id'
    ];
}
