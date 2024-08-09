<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 
        'subject_id', 
        'course_id', 
        'lecture_id', 
        'question', 
        'answer', 
        'status', 
        'difficulty'
    ];

    protected $casts = [
        'answer' => 'array',
    ];

    protected $randomizeAnswers = false; // Property to control randomization

    public function admin(): BelongsTo
    {
        return $this->belongsTo( Admin::class );
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

    public function questionLogs()
    {
        return $this->hasMany( QuestionLog::class );
    }

    public function userQuestionLog()
    {
        return $this->hasOne(QuestionLog::class);
    }



    // Accessor to get the answer attribute
    public function getAnswerAttribute($value)
    {
        $answerArray = json_decode($value, true); // Decode JSON to array if stored as JSON
        if ($this->randomizeAnswers && is_array($answerArray)) {
            shuffle($answerArray); // Randomize the array if the flag is true
        }
        return $answerArray;
    }

    // Method to enable randomization
    public function enableRandomization()
    {
        $this->randomizeAnswers = true;
        return $this;
    }
}
