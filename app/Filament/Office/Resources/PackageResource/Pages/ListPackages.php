<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Filament\Office\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Send New Package')->translateLabel(),
        ];
    }

}
