<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'voucher_balance',
        'total_roi_earned',
        'total_level_earned',
        'total_withdrawn',
        'total_deposited',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
