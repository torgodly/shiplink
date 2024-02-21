<?php

namespace App\Action;

use App\Enums\ShippingMethods;
use App\Enums\ShippingStatus;
use Filament\Tables\Filters\SelectFilter;

class PackageFilterHelper
{
    public static function setPackageFilter()
    {
        return [

            SelectFilter::make('status')
                ->translateLabel()
                ->options(collect(ShippingStatus::array())->map(fn($value, $key) => __($key))->toArray()),
            SelectFilter::make('shipping_method')
                ->translateLabel()
                ->options(collect(ShippingMethods::array())->map(fn($value, $key) => __($value))->toArray()),
            SelectFilter::make('sender_branch_id')
                ->label('Sender Branch')
                ->translateLabel()
                ->relationship('senderBranch', 'name')
                ->preload()
                ->searchable(),
            SelectFilter::make('receiver_branch_id')
                ->label('Receiver Branch')
                ->translateLabel()
                ->relationship('receiverBranch', 'name')
                ->preload()
                ->searchable(),


        ];
    }
}
