<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Filament\Office\Resources\PackageResource;
use App\Models\Package;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = 'ShipLink-' . Str::PadLeft(Package::query()->count() + 1, 7, '0');
        return $data;
    }
}
