<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LevelCommission extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'receiver_id',
        'from_user_id',
        'roi_income_id',
        'level',
        'roi_amount',
        'commission_percentage',
        'commission_amount',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function roiIncome()
    {
        return $this->belongsTo(ROIIncome::class, 'roi_income_id');
    }
}
