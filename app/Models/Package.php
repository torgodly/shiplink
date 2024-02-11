<?php

namespace App\Models;

use App\Enums\ShippingMethods;
use App\Enums\ShippingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'sender_code',
        'receiver_code',
        'sender_branch_id',
        'receiver_branch_id',
        'weight',
        'height',
        'width',
        'length',
        'fragile',
        'fast_shipping',
        'shipping_method',
        'insurance',
        'status',
        'description',
        'is_refrigerated',
        'signature',
        'payment_method'


    ];

    //sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_code', 'sender_code')->where('type', 'user');
    }

    //receiver
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_code', 'receiver_code')->where('type', 'user');
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

    public function getPriceAttribute()
    {
        $price = $this->weight * 0.5 + $this->height * $this->width * $this->length * 0.002;

        if ($this->fragile) {
            $price += 10;
        }

        if ($this->fast_shipping) {
            $price += 20;
        }

        switch ($this->shipping_method) {
            case ShippingMethods::Air->value:
                $price += 15;
                break;
            case ShippingMethods::Sea->value:
                $price += 10;
                break;
            case ShippingMethods::Land->value:
                $price += 5;
                break;
            case ShippingMethods::Other->value:
                $price += 7;
                break;
        }

        if ($this->insurance) {
            $price += $this->weight * 0.1;
        }

        return round($price) . ' LYD';
    }

    //attributes sender branch name
    public function getSenderBranchNameAttribute()
    {
        return $this->senderBranch->name;
    }

    //attributes receiver branch name
    public function getReceiverBranchNameAttribute()
    {
        return $this->receiverBranch->name;
    }

    //sernder info array
    public function getSenderInfoAttribute()
    {
        return [
            'name' => $this->sender->name,
            'phone' => $this->sender->phone,
            'custom_fields' => [
                'sender code' => $this->sender->sender_code,
                'sender branch' => $this->senderBranch->name
            ],
        ];
    }

    //receiver info array
    public function getReceiverInfoAttribute()
    {
        return [
            'name' => $this->receiver->name,
            'phone' => $this->receiver->phone,
            'custom_fields' => [
                'receiver code' => $this->receiver->receiver_code,
                'receiver branch' => $this->receiverBranch->name
            ],
        ];
    }


    //statusOptions
    public function getCustomStatusOptionsAttribute(): array
    {
        // Check if the package's sender branch is the same as the authenticated user's branch
        $isFromAuthUserBranch = $this->sender_branch_id === Auth::user()->mangedbrance->id;
        // Get all status options
        $allStatusOptions = collect(ShippingStatus::values());

        // If the package is from the authenticated user's branch, return first two status options
        if ($isFromAuthUserBranch) {
            return $allStatusOptions->take(2)->toArray();
        }

        // If the package is not from the authenticated user's branch, return the last two status options
        return $allStatusOptions->slice(-3)->toArray();
    }

}
