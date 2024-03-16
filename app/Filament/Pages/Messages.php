<?php

namespace App\Filament\Pages;

use App\Models\Message;
use Filament\Pages\Page;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class Messages extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'tabler-messages';

    protected static string $view = 'filament.pages.messages';

    /**
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('Messages');
    }



    public function getHeading(): string|Htmlable
    {
        return __(parent::getHeading());
    }



    public function table(Table $table): Table
    {
        return $table
            ->query(Message::query())
            ->columns([

                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make()->recordTitle('الرسالة'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
