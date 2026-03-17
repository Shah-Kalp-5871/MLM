<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubLevel extends Model
{
    protected $fillable = [
        'level',
        'title',
        'direct_required',
        'team_required',
        'reward_amount',
    ];
}
