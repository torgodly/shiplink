<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
use App\Models\Package;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Concerns\HasBadge;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ShowProgress extends Page implements HasInfolists, HasActions, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithActions;
    use InteractsWithForms;

//    use InteractsWithRecord;
    use HasBadge;

    protected static string $resource = PackageResource::class;
    protected static string $view = 'filament.office.resources.package-resource.pages.show-progress';
    public Package $record;

    public function ChangeStatusAction(): Action
    {
        return Action::make('ChangeStatus')
            ->label('Change Status')
            ->record($this->record)
            ->form([
                Select::make('status')
                    ->options($this->record->CustomStatusOptions)
                    ->default(fn(Package $record) => $record->status)
                    ->live()
                    ->required(),
                SignaturePad::make('signature')
                    ->default(fn(Package $record) => $record->signature)
                    ->requiredIf('status', 'Delivered')
                    ->backgroundColor('transparent')
                    ->visible(fn($get) => $get('status') === 'Delivered')

            ])
            // ...
            ->action(function (array $data): void {
                $selectedOption = $data['status'];
                $signature = $data['signature'] ?? null; // Provide a default value (null) if 'signature' is not set
                $this->record->update(['status' => $selectedOption, 'signature' => $signature]);
            })->requiresConfirmation()
            ->icon('tabler-package')
            ->modalIcon('tabler-package')
            ->modalDescription('Change the status of this package.');
    }

    public function activityTimelineInfolist(Infolist $infolist): Infolist
    {
        $currentStatus = $this->record->status;
        $PackageStatus = [
            [
                'title' => 'Order Placed - Awaiting Processing',
                'description' => 'Your order has been placed and is awaiting processing.',
                'status' => 'Pending',
                'created_at' => now(), // Adjust the date accordingly
            ],
            [
                'title' => 'Shipment In Transit - On its Way',
                'description' => 'Your order is on its way.',
                'status' => 'InTransit',
                'created_at' => now()->addDays(2), // Adjust the date accordingly
            ],
            [
                'title' => 'Shipment Out for Delivery',
                'description' => 'Your order is out for delivery and will arrive soon.',
                'status' => 'OutForDelivery',
                'created_at' => now()->addDays(4), // Adjust the date accordingly
            ],
            [
                'title' => 'Shipment Ready for Pickup',
                'description' => 'Your order is ready for pickup.',
                'status' => 'WaitingForPickup',
                'created_at' => now()->addDays(5), // Adjust the date accordingly
            ],
            [
                'title' => 'Order Delivered - Completed',
                'description' => 'Your order has been delivered.',
                'status' => 'Delivered',
                'created_at' => now()->addDays(6), // Adjust the date accordingly
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
                    ->label('Package Status' . ' (' . $this->record->code . ')')
                    ->description('These are the activities that have been recorded.')
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


                    ])
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
