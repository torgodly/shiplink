<?php

namespace App\Traits;

use Filament\Actions\Action;

trait HasRatingAction
{
    public function RatingAction(): Action
    {
        return Action::make('Rating')
            ->label('Rating')
            ->translateLabel()
            ->record($this->record)
            ->form([
////                TODO: crete star rating field and remove teh old pakage
//                Rating::make('rating')
//                    ->label('Rating')
//                    ->required()


            ])
            // ...
            ->action(function (array $data): void {

                dd($data);
                $this->record->update($data);
            })->requiresConfirmation()
            ->icon('tabler-star')
            ->modalIcon('tabler-package')
            ->color('yellow')
            ->modalDescription(__('Change the status of this package.'));
    }

}
