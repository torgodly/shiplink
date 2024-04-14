<?php

namespace App\Traits;

use App\Models\Package;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

trait HasChangeStatusAction
{
    public function ChangeStatusAction()
    {

        return Action::make('ChangeStatus')
            ->label('Change Status')
            ->translateLabel()
            ->record($this->record)
            ->fillForm($this->record->toArray())
            ->form([
                Select::make('status')
                    ->translateLabel()
                    ->options(collect($this->record->custom_status_options)->mapWithKeys(fn($status) => [$status => __($status)])->toArray())
                    ->live()
                    ->required()
                    ->native(false),
                SignaturePad::make('signature')
                    ->default(fn(Package $record) => $record->signature)
                    ->requiredIf('status', 'Delivered')
                    ->backgroundColor('transparent')
                    ->visible(fn($get) => $get('status') === 'Delivered')
                ,
                Select::make('transit_branch_id')
                    ->label('Transit Branch')
                    ->translateLabel()
                    ->requiredIf('status', 'InTransit')
                    ->native(false)
                    ->relationship('transitBranch', 'name')
                    ->visible(fn($get) => $get('status') === 'InTransit')
            ])
            // ...
            ->action(function (array $data): void {
                $selectedOption = $data['status'];
                $signature = $data['signature'] ?? null; // Provide a default value (null) if 'signature' is not set
                $data = ['status' => $selectedOption, 'signature' => $signature];
                $this->record->update($data);
                $message = [
                    'Pending' => 'The shipment status has been updated and it is now on wait.',
                    'Processing' => 'The shipment status has been updated and is now being processed.',
                    'OutForDelivery' => 'The shipment status has been updated and it is now out for delivery.',
                    'InTransit' => 'The shipment status has been updated and it is now in transit in ',
                    'WaitingForPickup' => 'The shipment status has been updated and it is now awaiting pickup.',
                    'Returned' => 'The shipment status has been updated and it has been returned to the sending branch.',
                    'Delivered' => 'The shipment status has been updated and it has been delivered.',
                ];
                Notification::make()
                    ->title($this->record->code . ' - ' . __($message[$selectedOption]) . ' ' . match ($selectedOption) {
                            'InTransit' => $this->record->transitBranch->name,
                            default => '',
                        })
                    ->icon(fn(): string|null => match ($selectedOption) {
                        'Pending' => 'tabler-clock',
                        'Processing' => 'tabler-settings-cog',
                        'OutForDelivery' => 'tabler-location-share',
                        'InTransit' => 'tabler-clock-pause',
                        'WaitingForPickup' => 'tabler-package',
                        'Delivered' => 'tabler-discount-check-filled',
                        'Returned' => 'tabler-refresh',
                        default => null,
                    })
                    ->iconColor(fn(): string|null => match ($selectedOption) {
                        'Processing' => 'blue',
                        'OutForDelivery' => 'yellow',
                        'InTransit' => 'sky',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
                        'Returned' => 'danger',
                        default => 'gray',
                    })
                    ->color(fn(): string|null => match ($selectedOption) {
                        'Processing' => 'blue',
                        'OutForDelivery' => 'yellow',
                        'InTransit' => 'sky',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
                        'Returned' => 'danger',
                        default => 'gray',
                    })
                    ->send()
                    ->sendToDatabase($this->record->sender)
                    ->sendToDatabase($this->record->receiver);

            })->requiresConfirmation()
            ->icon('tabler-package')
            ->modalIcon('tabler-package')
            ->modalDescription(__('Change the status of this package.'));
    }


    public function PendingAction(): Action
    {
        return Action::make('Pending')
            ->label('Pending')
            ->translateLabel()
            ->action(function (array $data): void {
                $this->updateStatus('Pending');
            })->requiresConfirmation()
            ->icon('tabler-clock')
            ->color($this->record->status === 'Pending' ? 'gray' : 'green',)
            ->disabled(fn(): bool => $this->record->senderBranch->manager->id != auth()->id())
            ->modalIcon('tabler-clock')
            ->modalDescription(__('Change the status of this package to Pending.'));
    }

    private function updateStatus(string $status, ?string $signature = null): void
    {
        $data = ['status' => $status, 'signature' => $signature];
        $this->record->update($data);
        $message = [
            'Pending' => 'The shipment status has been updated and it is now on wait.',
            'Processing' => 'The shipment status has been updated and is now being processed.',
            'OutForDelivery' => 'The shipment status has been updated and it is now out for delivery.',
            'InTransit' => 'The shipment status has been updated and it is now in transit in ',
            'WaitingForPickup' => 'The shipment status has been updated and it is now awaiting pickup.',
            'Returned' => 'The shipment status has been updated and it has been returned to the sending branch.',
            'Delivered' => 'The shipment status has been updated and it has been delivered.',
        ];
        Notification::make()
            ->title($this->record->code . ' - ' . __($message[$status]) . ' ' . match ($status) {
                    'InTransit' => $this->record->transitBranch->name,
                    default => '',
                })
            ->icon(fn(): string|null => match ($status) {
                'Pending' => 'tabler-clock',
                'Processing' => 'tabler-settings-cog',
                'OutForDelivery' => 'tabler-location-share',
                'InTransit' => 'tabler-clock-pause',
                'WaitingForPickup' => 'tabler-package',
                'Delivered' => 'tabler-discount-check-filled',
                'Returned' => 'tabler-refresh',
                default => null,
            })
            ->iconColor(fn(): string|null => match ($status) {
                'Processing' => 'blue',
                'OutForDelivery' => 'yellow',
                'InTransit' => 'sky',
                'WaitingForPickup' => 'orange',
                'Delivered' => 'green',
                'Returned' => 'danger',
                default => 'gray',
            })
            ->color(fn(): string|null => match ($status) {
                'Processing' => 'blue',
                'OutForDelivery' => 'yellow',
                'InTransit' => 'sky',
                'WaitingForPickup' => 'orange',
                'Delivered' => 'green',
                'Returned' => 'danger',
                default => 'gray',
            })
            ->send()
            ->sendToDatabase($this->record->sender)
            ->sendToDatabase($this->record->receiver);
    }

    public function ProcessingAction(): Action
    {
        return Action::make('Processing')
            ->label('Processing')
            ->translateLabel()
            ->action(function (array $data): void {
                $this->updateStatus('Processing');
            })->requiresConfirmation()
            ->color($this->record->status === 'Processing' ? 'gray' : 'blue',)
            ->disabled(fn(): bool => $this->record->senderBranch->manager->id != auth()->id())
            ->icon('tabler-settings-cog')
            ->modalIcon('tabler-settings-cog')
            ->modalDescription(__('Change the status of this package to Processing.'));
    }

    public function OutForDeliveryAction(): Action
    {
        return Action::make('OutForDelivery')
            ->label('Out For Shipping')
            ->translateLabel()
            ->action(function (array $data): void {
                $this->updateStatus('OutForDelivery');
            })->requiresConfirmation()
            ->color($this->record->status == 'OutForDelivery' ? 'gray' : 'yellow',)
            ->disabled(fn(): bool => $this->record->senderBranch->manager->id != auth()->id())
            ->icon('tabler-location-share')
            ->modalIcon('tabler-location-share')
            ->modalDescription(__('Change the status of this package to Out For Delivery.'));
    }

    public function InTransitAction(): Action
    {
        return Action::make('InTransit')
            ->label('In Transit')
            ->translateLabel()
            ->record($this->record)
            ->fillForm($this->record->toArray())
            ->form([
                Select::make('transit_branch_id')
                    ->label('Transit Branch')
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->relationship('transitBranch', 'name')
            ])
            ->action(function (array $data): void {
                $this->updateStatus('InTransit');
            })->requiresConfirmation()
            ->color($this->record->status == 'InTransit' ? 'gray' : 'sky',)
            ->disabled(fn(): bool => $this->record->senderBranch->manager->id != auth()->id())
            ->disabled(fn(): bool => $this->record->status != 'OutForDelivery')
            ->icon('tabler-clock-pause')
            ->modalIcon('tabler-clock-pause')
            ->modalDescription(__('Change the status of this package to In Transit.'));
    }

    public function WaitingForPickupAction(): Action
    {
        return Action::make('WaitingForPickup')
            ->label('Waiting For Pickup')
            ->translateLabel()
            ->action(function (array $data): void {
                $this->updateStatus('WaitingForPickup');
            })
            ->requiresConfirmation()
            ->color($this->record->status == 'WaitingForPickup' ? 'gray' : 'orange')
            ->disabled(fn(): bool => $this->record->receiverBranch->manager->id != auth()->id())
            ->icon('tabler-package')
            ->modalIcon('tabler-package')
            ->modalDescription(__('Change the status of this package to Waiting For Pickup.'));
    }

    public function ReturnedAction(): Action
    {
        return Action::make('Returned')
            ->label('Returned')
            ->translateLabel()
            ->action(function (array $data): void {
                $this->updateStatus('Returned');
            })->requiresConfirmation()
            ->color('danger')
            ->icon('tabler-refresh')
            ->disabled(fn(): bool => $this->record->receiverBranch->manager->id != auth()->id())
            ->modalIcon('tabler-refresh')
            ->modalDescription(__('Change the status of this package to Returned.'));
    }

    public function DeliveredAction(): Action
    {
        return Action::make('Delivered')
            ->label('Delivered')
            ->translateLabel()
            ->record($this->record)
            ->fillForm($this->record->toArray())
            ->form([
                SignaturePad::make('signature')
                    ->default(fn(Package $record) => $record->signature)
                    ->required()
                    ->backgroundColor('transparent')
            ])
            ->action(function (array $data): void {
                $this->updateStatus('Delivered', $data['signature']);
            })->requiresConfirmation()
            ->color('green')
            ->disabled(fn(): bool => $this->record->receiverBranch->manager->id != auth()->id())
            ->icon('tabler-discount-check-filled')
            ->modalIcon('tabler-discount-check-filled')
            ->modalDescription(__('Change the status of this package to Delivered.'));
    }


}
