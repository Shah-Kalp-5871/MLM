<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'tier',
        'name',
        'direct_business_target',
        'team_business_target',
        'voucher_value',
        'exclusive_perks',
    ];

    protected $casts = [
        'exclusive_perks' => 'array',
    ];
}
