<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direct_business',
        'team_business',
        'current_tier',
        'highest_tier_achieved',
        'last_calculated_at',
    ];

    protected $casts = [
        'last_qualified_at' => 'datetime',
        'is_qualified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
