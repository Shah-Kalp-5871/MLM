<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, \Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'referral_code',
        'upline_id',
        'status',
        'direct_business',
        'team_business',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'upline_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function roiIncomes()
    {
        return $this->hasMany(ROIIncome::class);
    }

    public function levelCommissions()
    {
        return $this->hasMany(LevelCommission::class, 'receiver_id');
    }

    public function sentCommissions()
    {
        return $this->hasMany(LevelCommission::class, 'from_user_id');
    }
}

