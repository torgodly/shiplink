<?php

namespace App\Filament\User\Resources\ReceivedPackagesResource\Pages;

use App\Enums\ShippingStatus;
use App\Filament\User\Resources\ReceivedPackagesResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;

class ViewPackage extends ViewRecord
{
    protected static string $resource = ReceivedPackagesResource::class;



    public function infolist(Infolist $infolist): Infolist
    {
        $currentStatus = $this->record->status;
        $PackageStatus = [
            [
                'title' => __("🎉 Order Confirmed - We're On It!"),
                'description' => __('Great news! We have received your order and are working on it with utmost priority. Stay tuned for updates!'),
                'status' => 'Pending',
                'created_at' => now(), // Adjust the date accordingly
            ],
            [
                'title' => __('✈️ Your Package is Flying High - In Transit!'),
                'description' => __('Your package is on the move and making swift progress towards you. It won’t be long now!'),
                'status' => 'OutForDelivery',
                'created_at' => now(), // Adjust the date accordingly
            ],
            [
                'title' => __('📍 Package Ready for Pickup - Almost Yours!'),
                'description' => __('Exciting news! Your package awaits you at the designated pickup point. It’s almost in your hands!'),
                'status' => 'WaitingForPickup',
                'created_at' => now(), // Adjust the date accordingly
            ],
            [
                'title' => __('🚚 Package Delivered - Enjoy Your Item!'),
                'description' => __('Hooray! Your package has safely arrived. We hope it brings you joy. Thanks for choosing us!'),
                'status' => 'Delivered',
                'created_at' => now(), // Adjust the date accordingly
            ],

        ];
        $statusOrder = ShippingStatus::values();

        $currentStatusIndex = array_search($currentStatus, $statusOrder);
        $PackageStatus = array_filter($PackageStatus, fn($activity) => array_search($activity['status'], $statusOrder) <= $currentStatusIndex);

        return $infolist
            ->name('somethingss')
            ->state(['PackageStatus' => array_values($PackageStatus)])
            ->schema([

                /*
                   You should enclose the entire components within a personalized "ActivitySection" entry.
                   This section functions identically to the repeater entry; you simply have to provide the array state's key.
                */

                ActivitySection::make('PackageStatus')
                    ->label(__('Package Status') . ' (' . $this->record->code . ')')
                    ->description(__('Follow the progress of your package.'))
                    ->schema([
                        ActivityTitle::make('title')
                            ->placeholder('No title is set'),
                        ActivityDescription::make('description')
                            ->placeholder('No description is set'),
                        ActivityDate::make('created_at')
                            ->date('F j, Y', 'Asia/Manila')
                            ->placeholder('No date is set.'),
                        ActivityIcon::make('status')
                            ->icon(fn(string|null $state): string|null => match ($state) {
                                'Pending' => 'tabler-clock',
                                'InTransit' => 'tabler-truck-delivery',
                                'OutForDelivery' => 'tabler-location-share',
                                'WaitingForPickup' => 'tabler-package',
                                'Delivered' => 'tabler-discount-check-filled',
                                default => null,
                            })
                            ->color(fn(string|null $state): string|null => match ($state) {
                                'Pending' => $this->record->status === 'Pending' ? 'gray' : 'green',
                                'InTransit' => $this->record->status === 'InTransit' ? 'gray' : 'blue',
                                'OutForDelivery' => $this->record->status === 'OutForDelivery' ? 'gray' : 'yellow',
                                'WaitingForPickup' => $this->record->status === 'WaitingForPickup' ? 'gray' : 'orange',
                                'Delivered' => 'green',
                                default => 'gray',
                            }),


                    ])->columnSpanFull()
//                    ->showItemsCount(2) // Show up to 2 items
//                    ->showItemsLabel('View Old') // Show "View Old" as link label
//                    ->showItemsIcon('heroicon-m-chevron-down') // Show button icon
//                    ->showItemsColor('gray') // Show button color and it supports all colors
//                    ->aside(true)
                    ->headingVisible(true) // make heading visible or not
//                    ->extraAttributes(['class' => 'my-new-class']) // add extra class
            ]);
    }

}
