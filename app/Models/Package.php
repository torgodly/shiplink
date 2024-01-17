<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_code',
        'receiver_code',
        'sender_branch_id',
        'receiver_branch_id',
        'weight',
        'height',
        'width',
        'length',
        'fragile',
        'hazardous',
        'shipping_method',
        'insurance',
        'status',
        'description',
        'requires_signature',
        'is_refrigerated',
        'payment_method'


    ];

    //sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_code', 'sender_code')->where('type','user');
    }

    //receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_code', 'receiver_code')->where('type','user');
    }

    //sender branch
    public function senderBranch()
    {
        return $this->belongsTo(Branch::class, 'sender_branch_id', 'id');
    }

    //receiver branch
    public function receiverBranch()
    {
        return $this->belongsTo(Branch::class, 'receiver_branch_id', 'id');
    }

    //dimensions is the calculated weight , height , width , length Attributes
    public function getDimensionsAttribute()
    {
        return "$this->height cm x $this->width cm x $this->length cm";
    }
}
