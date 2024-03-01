<?php

namespace App\Enums;
enum ShippingMethods: string
{
    use \App\Traits\Enum;
    case Air = 'Air';
    case Sea = 'Sea';
    case Land = 'Land';
}
