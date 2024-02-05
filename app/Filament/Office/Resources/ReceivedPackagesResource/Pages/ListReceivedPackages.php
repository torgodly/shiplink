<?php

namespace App\Filament\Office\Resources\ReceivedPackagesResource\Pages;

use App\Filament\Office\Resources\ReceivedPackagesResource;
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
