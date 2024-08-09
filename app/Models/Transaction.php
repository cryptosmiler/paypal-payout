<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'user_id',
        'course_id',
        'lecture_id',
        'transaction_id',
        'type',
        'title',
        'content',
        'amount',
        'date',
        'videos', 
        'mins', 
        'questions', 
        'question_ids'
    ];

    protected $casts = [
        'question_ids' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->question_ids)) {
                $model->question_ids = [];
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
