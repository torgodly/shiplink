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
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
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

    public function getTitle(): string|Htmlable
    {
        return __('Package Progress');
    }


    public function ChangeStatusAction(): Action
    {
        return Action::make('ChangeStatus')
            ->label('Change Status')
            ->translateLabel()
            ->record($this->record)
            ->form([
                Select::make('status')
                    ->translateLabel()
                    ->options(Arr::except(collect($this->record->CustomStatusOptions)->mapWithKeys(fn($status) => [$status => __($status)])->toArray(), [$this->record->status]))
                    ->live()
                    ->required()
                    ->native(false),
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
                $data = ['status' => $selectedOption, 'signature' => $signature];
                $this->record->update($data);
            })->requiresConfirmation()
            ->icon('tabler-package')
            ->modalIcon('tabler-package')
            ->modalDescription(__('Change the status of this package.'));
    }

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
                                'InTransit' => 'tabler-truck-delivery',
                                'OutForDelivery' => 'tabler-location-share',
                                'WaitingForPickup' => 'tabler-package',
                                'Delivered' => 'tabler-discount-check-filled',
                                'Returned' => 'tabler-refresh',
                                default => null,
                            })
                            ->color(fn(string|null $state): string|null => match ($state) {
                                'Pending' => $this->record->status === 'Pending' ? 'gray' : 'green',
                                'InTransit' => $this->record->status === 'InTransit' ? 'gray' : 'blue',
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
