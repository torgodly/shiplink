<?php

namespace App\Filament\User\Resources\SentPackagesResource\Pages;

use App\Filament\User\Resources\SentPackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSentPackages extends ListRecords
{
    protected static string $resource = SentPackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
