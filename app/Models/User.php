<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
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
    ];

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() == 'admin' ) {
            return $this->type == 'admin';
        } elseif ($panel->getId() == 'office') {
            return $this->type == 'manager';
        }
        return false;
    }

    //belongs to branch

    public function mangedbrance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Branch::class, 'manager_id');
    }

    //brance name
    public function getBranchNameAttribute()
    {
        return $this->mangedbrance?->name;
    }

    public function getIsAdminAttribute()
    {
        return $this->type == 'admin';
    }


}
