<?php

namespace App\Filament\User\Resources\SentPackagesResource\Pages;

use App\Filament\User\Resources\SentPackagesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSentPackages extends EditRecord
{
    protected static string $resource = SentPackagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
