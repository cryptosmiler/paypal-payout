<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'question_id', 
        'answer', 
        'status',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
