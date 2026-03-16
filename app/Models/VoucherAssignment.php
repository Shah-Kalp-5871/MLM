<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherAssignment extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'voucher_id',
        'user_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
