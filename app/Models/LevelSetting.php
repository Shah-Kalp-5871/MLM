<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LevelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'percentage',
        'label',
    ];
}
