<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'milestone_id',
        'reward_type', // cash, voucher, asset
        'reward_value',
        'status', // pending, awarded, claimed
        'claimed_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function milestone()
    {
        return $this->belongsTo(ClubMilestone::class, 'milestone_id');
    }
}
