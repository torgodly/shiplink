<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Filament\Office\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = 'ShipLink-' . Str::random(10);
        return $data;
    }
}
