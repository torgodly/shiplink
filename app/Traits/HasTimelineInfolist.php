<?php

namespace App\Traits;

use App\Enums\ShippingStatus;
use Filament\Infolists\Infolist;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;

trait HasTimelineInfolist
{

    public function activityTimelineInfolist(Infolist $infolist): Infolist
    {
        $currentStatus = $this->record->status;
        $PackageStatus = [
            [
                'title' => __("🎉 Order Confirmed - We're On It!"),
                'description' => __('Great news! We have received your order and are working on it with utmost priority. Stay tuned for updates!'),
                'status' => 'Pending',
//                'created_at' => '-', // Adjust the date accordingly
            ],
            [
                'title' => __('✈️ Your Package is on its way!'),
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
                'title' => __('📦 Package Returned - Awaiting Pickup!'),
                'description' => __('Your package has been returned to the sender branch and is awaiting pickup. Please contact us for further assistance.'),
                'status' => 'Returned',
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


        // Adjusted logic to filter PackageStatus based on currentStatus
        if ($currentStatus === 'Returned') {
            // If status is Returned, exclude Delivered status
            $PackageStatus = array_filter($PackageStatus, fn($activity) => $activity['status'] !== 'Delivered');
        } elseif ($currentStatus === 'Delivered') {
            // If status is Delivered, exclude Returned status
            $PackageStatus = array_filter($PackageStatus, fn($activity) => $activity['status'] !== 'Returned');
        } else {
            // For other statuses, show up to the current status
            $currentStatusIndex = array_search($currentStatus, $statusOrder);
            $PackageStatus = array_filter($PackageStatus, fn($activity) => array_search($activity['status'], $statusOrder) <= $currentStatusIndex);
        }

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

                        ActivityIcon::make('status')
                            ->icon(fn(string|null $state): string|null => match ($state) {
                                'Pending' => 'tabler-clock',
                                'OutForDelivery' => 'tabler-location-share',
                                'WaitingForPickup' => 'tabler-package',
                                'Delivered' => 'tabler-discount-check-filled',
                                'Returned' => 'tabler-refresh',
                                default => null,
                            })
                            ->color(fn(string|null $state): string|null => match ($state) {
                                'Pending' => $this->record->status === 'Pending' ? 'gray' : 'green',
                                'OutForDelivery' => $this->record->status === 'OutForDelivery' ? 'gray' : 'yellow',
                                'WaitingForPickup' => $this->record->status === 'WaitingForPickup' ? 'gray' : 'orange',
                                'Delivered' => 'green',
                                'Returned' => 'danger',
                                default => 'gray',
                            }),


                    ])
                    ->headingVisible(true)
            ]);
    }

}
