<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 
        'subject_id', 
        'course_id', 
        'title', 
        'description', 
        'order', 
        'video', 
        'video_40s', 
        'video_name', 
        'size', 
        'duration', 
        'status', 
    ];

    protected $appends = ['video_url'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo( Admin::class );
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo( Admin::class, 'admin_id' );
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo( Subject::class );
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo( Course::class );
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);    
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }

    public function videoLogs()
    {
        return $this->hasMany(VideoLog::class);
    }



    public function getVideoUrlAttribute()
    {
        $course = $this->course;

        if (!$course) {
            return $this->video_40s;
        }

        // Check if the course is not free and there exists a transaction for this lecture
        $hasTransaction = $this->transactions()->exists();
        if (($course->charge == "pay" && $hasTransaction) || $course->charge == "free") {
            return $this->video;
        } else {
            return $this->video_40s;
        }
    }
}
