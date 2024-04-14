<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    //fillable
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'branch_id',
        'user_id',
        'answer',
    ];


    //branch name
    public function getBranchNameAttribute()
    {
       return $this->branch->name;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    //user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //username
    public function getUserNameAttribute()
    {
       return $this->user->name;
    }



}
