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
        return $this->hasMany(Voucher::class, 'owner_id');
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

    /**
     * Recursively calculate total team size (all downlines).
     */
    public function calculateTeamSize()
    {
        $count = 0;
        $referrals = $this->referrals()->get();
        
        foreach ($referrals as $referral) {
            $count++; // Count direct referral
            $count += $referral->calculateTeamSize(); // Count their referrals recursively
        }
        
        return $count;
    }

    /**
     * Check if this user is an ancestor of another user.
     * Useful for preventing circular referrals.
     */
    public function isAncestorOf($user)
    {
        $current = $user;
        while ($current && $current->upline_id) {
            if ($current->upline_id == $this->id) {
                return true;
            }
            $current = $current->upline;
        }
        return false;
    }
}

