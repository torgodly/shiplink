<?php

namespace App\Enums;
enum ShippingMethods: string
{
    use \App\Traits\Enum;
    case Air = 'air';
    case Sea = 'sea';
    case Land = 'land';
    case Other = 'other';
}
