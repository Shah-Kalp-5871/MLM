<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'value',
        'club_reward_id',
        'status', // unused, assigned, redeemed, expired
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOneThrough(User::class, VoucherAssignment::class, 'voucher_id', 'id', 'id', 'user_id');
    }

    public function assignment()
    {
        return $this->hasOne(VoucherAssignment::class);
    }

    public function clubReward()
    {
        return $this->belongsTo(ClubReward::class);
    }
}
