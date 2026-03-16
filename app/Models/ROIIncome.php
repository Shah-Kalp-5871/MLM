<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ROIIncome extends Model
{
    use HasFactory;
    
    protected $table = 'roi_incomes';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'investment_id',
        'investment_amount',
        'roi_percentage',
        'roi_amount',
        'week_number',
        'for_week_ending',
        'distributed_at',
    ];

    protected $casts = [
        'payout_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
}
