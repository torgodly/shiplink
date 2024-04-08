<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->visible(fn ($record) => $record->status === ShippingStatus::Pending->value or $record->status === ShippingStatus::Processing->value),
        ];
    }
}
