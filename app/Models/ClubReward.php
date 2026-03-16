<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'club_milestone_id',
        'tier',
        'reward_amount',
        'status', // awarded, assigned, redeemed, expired
        'awarded_at',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function milestone()
    {
        return $this->belongsTo(ClubMilestone::class, 'club_milestone_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
