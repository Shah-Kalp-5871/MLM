<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLMTree extends Model
{
    use HasFactory;
    protected $table = 'mlm_tree';
    public $timestamps = false; // Usually for closure tables we don't need timestamps

    protected $fillable = [
        'ancestor_id',
        'descendant_id',
        'distance',
    ];

    public function ancestor()
    {
        return $this->belongsTo(User::class, 'ancestor_id');
    }

    public function descendant()
    {
        return $this->belongsTo(User::class, 'descendant_id');
    }
}
