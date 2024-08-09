<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 
        'subject_id', 
        'title', 
        'description', 
        'image', 
        'coupon', 
        'visible', 
        'charge', 
        'video_price', 
        'question_price', 
        'price_verified_at', 
        'status', 
        'locale', 
        'order'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo( Admin::class );
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo( Subject::class );
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
