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
    ];


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    //manager name
    public function getManagerNameAttribute()
    {
        return $this->manager->name;
    }
}
