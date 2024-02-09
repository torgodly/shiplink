<?php

namespace App\Filament\User\Resources\ReceivedPackagesResource\Pages;

use App\Filament\User\Resources\ReceivedPackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceivedPackages extends EditRecord
{
    protected static string $resource = ReceivedPackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
