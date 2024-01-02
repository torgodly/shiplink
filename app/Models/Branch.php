<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'manager_id',
    ];

    //has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    //belongs to manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
