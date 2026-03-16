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
        'type', // club_reward, special, promo
        'assigned_to', // user_id
        'is_used',
        'used_at',
        'status', // active, expired, cancelled
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function redemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }
}
