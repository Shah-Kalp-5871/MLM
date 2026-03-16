<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'kyc_status', // pending, verified, rejected
        'kyc_documents',
    ];

    protected $casts = [
        'kyc_documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
