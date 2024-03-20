<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'city',
        'country',
        'manager_id',
        'status',
    ];


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    //manager name
    public function getManagerNameAttribute()
    {
        return $this->manager?->name;
    }


    //sent packages
    public function sentPackages()
    {
        return $this->hasMany(Package::class, 'sender_branch_id', 'id');
    }

    //received packages
    public function receivedPackages()
    {
        return $this->hasMany(Package::class, 'receiver_branch_id', 'id');
    }

    public function packages()
    {
        return $this->sentPackages()->union($this->receivedPackages());
    }

    //sent count
    public function getSentCountAttribute()
    {
        return $this->sentPackages()->count();
    }

    //received count
    public function getReceivedCountAttribute()
    {
        return $this->receivedPackages()->count();
    }


}
