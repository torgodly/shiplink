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

    protected $appends = [
        'sender_name',
        'receiver_name'
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
        // Assuming dimensions are in centimeters and weight is in kilograms
        $volumetricWeight = ($this->height * $this->width * $this->length) / 5000; // Volumetric weight calculation
        $actualWeight = max($this->weight, $volumetricWeight); // Take the maximum of actual weight and volumetric weight

        $price = 0;

        // Base price calculation based on weight and dimensions
        $price += $actualWeight * 20; // Base price per kg

        // Additional charges
        if ($this->fragile) {
            $price += 20; // Additional charge for fragile items
        }

        if ($this->fast_shipping) {
            $price += 50; // Additional charge for fast shipping
        }

        // Shipping method charges
        switch ($this->shipping_method) {
            case ShippingMethods::Air->value:
                $price += 100; // Air shipping charge
                break;
            case ShippingMethods::Sea->value:
                $price += 50; // Sea shipping charge
                break;
            case ShippingMethods::Land->value:
                $price += 30; // Land shipping charge
                break;
        }

        if ($this->insurance) {
            // Assuming insurance costs 1% of the declared value of the item
            $insuranceCost = 0.01 * ($this->weight * 20); // Assuming $20 per kg for declared value
            $price += $insuranceCost;
        }

        // Rounding the price to two decimal places and appending currency
        return number_format($price, 2) . ' د.ل';
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

    //sender name
    public function getSenderNameAttribute()
    {
        return $this->sender->name;
    }

    //receiver name
    public function getReceiverNameAttribute()
    {
        return $this->receiver->name;
    }

}
