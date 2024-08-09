<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 
        'amount', 
        'state', 
        'create_date', 
        'completed_date', 
        'payout_batch_id', 
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo( Admin::class, 'admin_id', 'id' );
    }

    public function scopeMonthlySumByAdmin($query)
    {
        return $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                'admin_id',
                DB::raw('SUM(amount) as total_amount'), 
                'completed_date'
            )
            ->groupBy('year', 'month', 'admin_id')
            ->orderBy('year', 'month');
    }
}
