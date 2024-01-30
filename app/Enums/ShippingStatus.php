<?php

namespace App\Enums;
enum ShippingStatus: string
{
    use \App\Traits\Enum;

    case Pending = 'Pending';
    case OutForDelivery = 'OutForDelivery';
    case WaitingForPickup = 'WaitingForPickup';
    case Delivered = 'Delivered';
}
