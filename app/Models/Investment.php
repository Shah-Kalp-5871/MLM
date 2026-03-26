<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
    use HasFactory, SoftDeletes;

    const MIN_QUALIFIED_AMOUNT = 500;

    protected $fillable = [
        'user_id',
        'amount',
        'daily_roi_percentage',
        'weekly_roi_percentage',
        'total_roi_earned',
        'next_payout_at',
        'matures_at',
        'status', // active, completed, cancelled
        'source',
    ];

    protected $casts = [
        'next_payout_at' => 'datetime',
        'matures_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function roiIncomes()
    {
        return $this->hasMany(ROIIncome::class);
    }
}
