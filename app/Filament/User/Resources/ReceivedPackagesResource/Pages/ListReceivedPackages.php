<?php

namespace App\Filament\User\Resources\ReceivedPackagesResource\Pages;

use App\Filament\User\Resources\ReceivedPackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceivedPackages extends ListRecords
{
    protected static string $resource = ReceivedPackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
