<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lecture_id',
        'datetime',
    ];

    public function lecture(): BelongsTo
    {
        return $this->belongsTo( Lecture::class );
    }
}
