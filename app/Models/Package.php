<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'min_price',
        'max_price',
        'roi_percentage', // weekly/daily depending on config
        'duration_days',
        'level_commission_enabled',
        'status',
    ];

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
