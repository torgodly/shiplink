<?php

namespace App\Enums;
enum ShippingStatus: string
{
    use \App\Traits\Enum;

    case Pending = 'Pending';

    case Processing = 'Processing';
    case OutForDelivery = 'OutForDelivery';

    case InTransit = "InTransit";
    case WaitingForPickup = 'WaitingForPickup';

    case Returned = 'Returned';
    case Delivered = 'Delivered';

}
