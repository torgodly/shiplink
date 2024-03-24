<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
        'sender_code',
        'receiver_code',
        'avatar_url',
        'active',
        'email_verified_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    use HasApiTokens, HasFactory, Notifiable;
    use TwoFactorAuthenticatable;
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->type === null) {
                $user->sender_code = 'SND-' . Str::random(10);
                $user->receiver_code = 'REC-' . Str::random(10);
            }
        });
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    //belongs to branch

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->type === 'admin';
        }

        if ($panel->getId() === 'office') {
            return $this->type === 'manager';
        }

        if ($panel->getId() === 'user') {
            return $this->type === 'user';
        }
        return false;
    }

    //brance name

    public function managedbranch(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Branch::class, 'manager_id');
    }

    //has a managedbranch


    public function getBranchNameAttribute()
    {
        return $this->managedbranch?->name;
    }


    // booted method if created user type is user then add sender code and receiver code

    public function getIsAdminAttribute()
    {
        return $this->type == 'admin';
    }
    //is manager
    public function getIsManagerAttribute()
    {
        return $this->type == 'manager';
    }

    //is user
    public function getIsUserAttribute()
    {
        return $this->type == 'user';
    }


    //Sent packages
    public function sentPackages()
    {
        return $this->hasMany(Package::class, 'sender_code', 'sender_code');
    }

    //Received packages
    public function receivedPackages()
    {
        return $this->hasMany(Package::class, 'receiver_code', 'receiver_code');
    }

}
