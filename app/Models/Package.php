<?php

namespace App\Models;

use App\Enums\ShippingMethods;
use App\Enums\ShippingStatus;
use Filament\Notifications\Notification;
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
        'payment_method',
        "rating"


    ];

    protected $appends = [
        'sender_name',
        'receiver_name',
        'price'
    ];

    //sender

    public static function getPrice($weight, $height, $width, $length, $fragile, $fast_shipping, $shipping_method, $insurance, $is_refrigerated): float
    {
        $volumetricWeight = ((float)$height * (float)$width * (float)$length) / 5000; // Volumetric weight calculation
        $actualWeight = max($weight, $volumetricWeight); // Take the maximum of actual weight and volumetric weight

        $price = 0;

        // Base price calculation based on weight and dimensions
        $price += $actualWeight * 5; // Base price per kg

        // Additional charges
        if ($fragile) {
            $price += 5; // Additional charge for fragile items
        }

        if ($fast_shipping) {
            $price += 5; // Additional charge for fast shipping
        }

        if ($is_refrigerated) {
            $price += 5; // Additional charge for refrigerated items
        }

        if ($insurance) {
            $price += 5; // Additional charge for insurance
        }

        // Shipping method charges
        switch ($shipping_method) {
            case ShippingMethods::Air->value:
                $price += 35; // Air shipping charge
                break;
            case ShippingMethods::Sea->value:
                $price += 25; // Sea shipping charge
                break;
            case ShippingMethods::Land->value:
                $price += 15; // Land shipping charge
                break;
        }



        // Rounding the price to two decimal places and appending currency
//        return (float)number_format($price, 2);
        return round($price, 2);
    }

    //receiver

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_code', 'sender_code')->where('type', 'user');
    }

    //sender branch

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_code', 'receiver_code')->where('type', 'user');
    }

    //receiver branch

    public function senderBranch()
    {
        return $this->belongsTo(Branch::class, 'sender_branch_id', 'id');
    }

    //dimensions is the calculated weight , height , width , length Attributes

    public function receiverBranch()
    {
        return $this->belongsTo(Branch::class, 'receiver_branch_id', 'id');
    }

    public function getDimensionsAttribute()
    {
        return "$this->height cm x $this->width cm x $this->length cm";
    }

    //pricenum


    //attributes sender branch name

    public function getPriceAttribute(): float
    {
        // Assuming dimensions are in centimeters and weight is in kilograms
        $volumetricWeight = ($this->height * $this->width * $this->length) / 5000; // Volumetric weight calculation
        $actualWeight = max($this->weight, $volumetricWeight); // Take the maximum of actual weight and volumetric weight

        $price = 0;

        // Base price calculation based on weight and dimensions
        $price += $actualWeight * 5; // Base price per kg

        // Additional charges
        if ($this->fragile) {
            $price += 5; // Additional charge for fragile items
        }

        if ($this->fast_shipping) {
            $price += 5; // Additional charge for fast shipping
        }

        if ($this->is_refrigerated) {
            $price += 5; // Additional charge for refrigerated items
        }

        if ($this->insurance) {
            $price += 5; // Additional charge for insurance
        }

        // Shipping method charges
        switch ($this->shipping_method) {
            case ShippingMethods::Air->value:
                $price += 35; // Air shipping charge
                break;
            case ShippingMethods::Sea->value:
                $price += 25; // Sea shipping charge
                break;
            case ShippingMethods::Land->value:
                $price += 15; // Land shipping charge
                break;
        }



        // Rounding the price to two decimal places and appending currency
//        return (float)number_format($price, 2);
        return round($price, 2);
    }

    //attributes receiver branch name

    public function getSenderBranchNameAttribute()
    {
        return $this->senderBranch->name;
    }

    //sernder info array

    public function getReceiverBranchNameAttribute()
    {
        return $this->receiverBranch->name;
    }

    //receiver info array

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


    //statusOptions

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

    //static function to get the price of the package by passing all the required parameters

    public function getCustomStatusOptionsAttribute(): array
    {
        // Check if the package's sender branch is the same as the authenticated user's branch
        $isFromAuthUserBranch = $this->sender_branch_id === Auth::user()->managedbranch->id;
        // Get all status options
        $allStatusOptions = collect(ShippingStatus::values());

        // If the package is from the authenticated user's branch, return first two status options
        if ($isFromAuthUserBranch) {
            return $allStatusOptions->take(4)->toArray();
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


    //Transit branch
    public function transitBranch()
    {
        return $this->belongsTo(Branch::class, 'transit_branch_id', 'id');
    }


    //Auth user is the sender bool
    public function getIsAuthUserSenderAttribute(): bool
    {
        return $this->sender_code === Auth::user()->sender_code;
    }

    //auth user is the reserved bool
    public function getIsAuthUserReceiverAttribute(): bool
    {
        return $this->receiver_code === Auth::user()->receiver_code;
    }

    //auth user is the sender branch bool
    public function getIsAuthUserSenderBranchAttribute(): bool
    {
        return $this->sender_branch_id === Auth::user()->managedbranch->id;
    }

    //auth user is the receiver branch bool
    public function getIsAuthUserReceiverBranchAttribute(): bool
    {
        return $this->receiver_branch_id === Auth::user()->managedbranch->id;
    }


    protected static function booted()
    {
        static::creating(function (Package $package) {
            Notification::make()->title(__("A new package with code "). $package->code .__(" has been created to be received at your branch"))->sendToDatabase($package->receiverBranch->manager);
            //send to the receiver user that a new pakcage is its on its way to him
            Notification::make()->title(__("A new package with code "). $package->code .__(" has been created to be received by you"))->sendToDatabase($package->receiver);
            //send to the sender user that the package has been created
            Notification::make()->title(__("A new package with code "). $package->code .__(" has been created to be sent by you"))->sendToDatabase($package->sender);
        });
    }

}
