<?php

namespace App\Traits;

use App\Models\Package;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

trait HasChangeStatusAction
{
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

}
