<?php

namespace App\Traits;

use App\Models\Package;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Notifications\Notification;

trait HasChangeStatusAction
{
    public function ChangeStatusAction(): Action
    {

        return Action::make('ChangeStatus')
            ->label('Change Status')
            ->translateLabel()
            ->record($this->record)
            ->fillForm($this->record->toArray())
            ->form([
                Select::make('status')
                    ->translateLabel()
                    ->options(collect($this->record->CustomStatusOptions)->mapWithKeys(fn($status) => [$status => __($status)])->toArray())
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
                Notification::make()
                    ->title(__('The Package '). '"'.$this->record->code.'"' .' is now' . __($selectedOption))
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
                        'OutForDelivery' =>  'yellow',
                        'InTransit' => 'sky',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
                        'Returned' => 'danger',
                        default => 'gray',
                    })
                    ->color(fn(): string|null => match ($selectedOption) {
                        'Processing' => 'blue',
                        'OutForDelivery' =>  'yellow',
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

}
