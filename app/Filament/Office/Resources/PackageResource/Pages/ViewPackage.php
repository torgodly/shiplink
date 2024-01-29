<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Filament\Office\Resources\PackageResource;
use App\Models\Package;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewPackage extends ViewRecord
{
    protected static string $resource = PackageResource::class;


    protected function getActions(): array
    {
        return [
            // Your existing actions...
            Action::make('Change Status')
                ->form([
                    Select::make('status')
                        ->options([
                            'pending' => 'pending',
                            'Out for Delivery' => 'Out for Delivery',
                            'Delivered' => 'Delivered',
                        ])
                        ->default(fn(Package $record) => $record->status)
                        ->required(),
                ])
                ->action(function (Package $record, array $data): void {
                    $selectedOption = $data['status'];
                    $record->update(['status' => $selectedOption]);
                })
                ->requiresConfirmation()
        ];
    }

}
