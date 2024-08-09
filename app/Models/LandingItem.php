<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 
        'title', 
        'description', 
        'video', 
        'image', 
        'order', 
        'status', 
        'locale'
    ];
}
