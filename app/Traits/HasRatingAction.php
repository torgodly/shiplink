<?php

namespace App\Traits;

use App\Forms\Components\Rating;
use Filament\Actions\Action;

trait HasRatingAction
{
    public function RatingAction(): Action
    {
        return Action::make('Rating')
            ->visible()
            ->label('Rating')
            ->translateLabel()
            ->fillForm($this->record->toArray())
            ->record($this->record)
            ->form([
////                TODO: crete star rating field and remove teh old pakage
                Rating::make('rating')
                    ->label('Rating')
                    ->translateLabel()
                    ->hiddenLabel()
                    ->autoSubmit()
                    ->required()

            ])
            // ...
            ->action(function (array $data): void {
//                dd($data);
                $this->record->update($data);
            })
            ->requiresConfirmation()
            ->icon('tabler-star')
            ->modalIcon('tabler-star')
            ->color('yellow')
            ->modalDescription(__('please Rate the shipping of this package'))
            ->modalWidth('max-w-sm')
//            ->visible(fn(): bool => $this->record->status === 'delivered' && $this->record->receiver_code === auth()->user()->receiver_code)
            ->modalCancelAction(false)
            ->modalSubmitAction(false);

    }

}
