<?php

namespace App\Filament\User\Resources\MessageResource\Pages;

use App\Filament\User\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
