<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreeUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 
        'user_id', 
        'subject_id', 
        'course_id', 
        'lecture_id', 
        'phone_prefix', 
        'phone_number', 
        'phone', 
    ];

    protected $with = ['teacher', 'subject', 'course', 'lecture'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo( Admin::class, 'admin_id',  'id' );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo( Subject::class );
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo( Course::class );
    }

    public function lecture(): BelongsTo
    {
        return $this->belongsTo( Lecture::class );
    }
}
