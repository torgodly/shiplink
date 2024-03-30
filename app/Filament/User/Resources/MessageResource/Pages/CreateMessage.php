<?php

namespace App\Filament\User\Resources\MessageResource\Pages;

use App\Filament\User\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMessage extends CreateRecord
{
    protected static string $resource = MessageResource::class;
}
