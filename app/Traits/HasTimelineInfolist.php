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
        $transit_branch_name = $this->record->transitBranch?->name;
        $destination_branch_name = $this->record->receiverBranch?->name;

        $PackageStatus = [
            [
                'title' => __("🎉 Order Confirmed - We're On It!"),
                'description' => __('Great news! We have received your order and are working on it with utmost priority. Stay tuned for updates!'),
                'status' => 'Pending',
//                'created_at' => '-', // Adjust the date accordingly
            ],
            [
                'title' => __('🔨 Order Processing - Almost Ready!'),
                'description' => __('Your order is being processed and will be ready for shipment soon. We appreciate your patience!'),
                'status' => 'Processing',
                'created_at' => now(), // Adjust the date accordingly
            ],

            ['title' => __('✈️ Your Package is on its way!'),
                'description' => __('Your package is on the move and making swift progress towards you. It won’t be long now!'),
                'status' => 'OutForDelivery',
                'created_at' => now(), // Adjust the date accordingly
            ],
            //in transit in "andd a place for tanst branch name"
            [
                'title' => __('🚚 Package is in Transit in '). $transit_branch_name . __(' - Next Stop: ') . $destination_branch_name,
                'description' => __('Your package is on the move and making swift progress towards you. It won’t be long now!'),
                'status' => 'InTransit',
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

        if ($this->record->transit_branch_id === null) {
            // If transit_branch_id is null exclude  InTransit
            $PackageStatus = array_filter($PackageStatus, fn($activity) => $activity['status'] !== 'InTransit');
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
                                'Processing' => 'tabler-settings-cog',
                                'OutForDelivery' => 'tabler-location-share',
                                'InTransit' => 'tabler-clock-pause',
                                'WaitingForPickup' => 'tabler-package',
                                'Delivered' => 'tabler-discount-check-filled',
                                'Returned' => 'tabler-refresh',
                                default => null,
                            })
                            ->color(fn(string|null $state): string|null => match ($state) {
                                'Pending' => $this->record->status === 'Pending' ? 'gray' : 'green',
                                'Processing' => $this->record->status === 'Processing' ? 'gray' : 'blue',
                                'OutForDelivery' => $this->record->status === 'OutForDelivery' ? 'gray' : 'yellow',
                                'InTransit' => $this->record->status === 'InTransit' ? 'gray' : 'sky',
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
