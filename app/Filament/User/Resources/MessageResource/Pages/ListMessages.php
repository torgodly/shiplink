<?php

namespace App\Filament\User\Resources\MessageResource\Pages;

use App\Filament\User\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListMessages extends ListRecords
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->createAnother(false)->mutateFormDataUsing(
                function (array $data) {

                    $data['user_id'] = auth()->id();
                    $data['name'] = auth()->user()->name;
                    $data['email'] = auth()->user()->email;
                    $data['phone'] = auth()->user()->phone;

                    return $data;
                }
            ),
        ];
    }
}
