<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'used_by',
        'code',
        'amount',
        'type',
        'status',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function redeemer()
    {
        return $this->belongsTo(User::class, 'used_by');
    }
}
