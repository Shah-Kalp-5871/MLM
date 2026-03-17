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
        'week_key',
        'investment_amount',
        'roi_percentage',
        'roi_amount',
        'week_number',
        'for_week_ending',
        'distributed_at',
    ];

    protected $casts = [
        'for_week_ending' => 'date',
        'distributed_at' => 'datetime',
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
