<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 
        'description', 
        'image', 
        'admin_id', 
        'recommend', 
        'locale'
    ];

    protected $with = ['admin'];


    public function admin(): BelongsTo
    {
        return $this->belongsTo( Admin::class );
    }


    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
