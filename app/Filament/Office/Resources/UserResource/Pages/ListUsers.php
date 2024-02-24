<?php

namespace App\Filament\Office\Resources\UserResource\Pages;

use App\Filament\Office\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(
                function (array $data) {

                        $data['sender_code'] = 'SND-' . Str::random(10);
                        $data['receiver_code'] = 'REC-' . Str::random(10);

                    return $data;
                }
            )->requiresConfirmation(true)->createAnother(false)->modalWidth('2xl')->icon('heroicon-o-plus-circle')->color('success')->modalIcon('heroicon-o-users'),
        ];
    }
}
