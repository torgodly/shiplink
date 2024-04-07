<?php

namespace App\Filament\User\Widgets;

use App\Enums\ShippingStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $sentPackages = \Auth::user()->sentPackages;
        $receivedPackages = \Auth::user()->receivedPackages;
        $totalPackages = $sentPackages->union($receivedPackages);
        //the count of packages of Shipping status
        $pendingPackages = $totalPackages->where('status', ShippingStatus::Pending->value)->count();
        $processingPackages = $totalPackages->where('status', ShippingStatus::Processing->value)->count();
        $outForDeliveryPackages = $totalPackages->where('status', ShippingStatus::OutForDelivery->value)->count();
        $intransitPackages = $totalPackages->where('status', ShippingStatus::InTransit->value)->count();
        $waitingForPickupPackages = $totalPackages->where('status', ShippingStatus::WaitingForPickup->value)->count();
        $deliveredPackages = $totalPackages->where('status', ShippingStatus::Delivered->value)->count();
        $returnedPackages = $totalPackages->where('status', ShippingStatus::Returned->value)->count();


        return [
            //sent packages
            Stat::make(__('Sent Packages'), $sentPackages->count())
                ->color('green')
                ->description(__('Total number of packages sent'))
                ->descriptionIcon('tabler-package-export')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            //received packages
            Stat::make(__('Received Packages'), $receivedPackages->count())
                ->color('green')
                ->description(__('Total number of packages received'))
                ->descriptionIcon('tabler-package-import')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //total packages
            Stat::make(__('Total Packages'), $totalPackages->count())
                ->color('blue')
                ->description(__('Total number of packages available'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),





            //pending packages
            Stat::make(__('Pending Packages'), $pendingPackages)
                ->color('yellow')
                ->description(__('Total number of packages pending'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //processing packages
            Stat::make(__('Processing Packages'), $processingPackages)
                ->color('yellow')
                ->description(__('Total number of packages processing'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //out for delivery packages
            Stat::make(__('Out For Delivery Packages'), $outForDeliveryPackages)
                ->color('yellow')
                ->description(__('Total number of packages out for delivery'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //in transit packages
            Stat::make(__('In Transit Packages'), $intransitPackages)
                ->color('yellow')
                ->description(__('Total number of packages in transit'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //waiting for pickup packages
            Stat::make(__('Waiting For Pickup Packages'), $waitingForPickupPackages)
                ->color('yellow')
                ->description(__('Total number of packages waiting for pickup'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //delivered packages
            Stat::make(__('Delivered Packages'), $deliveredPackages)
                ->color('green')
                ->description(__('Total number of packages delivered'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //returned packages
            Stat::make(__('Returned Packages'), $returnedPackages)
                ->color('danger')
                ->description(__('Total number of packages returned'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //


        ];
    }
}
