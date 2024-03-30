<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\MessageResource\Pages;
use App\Filament\User\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'tabler-messages';

    public static function getNavigationLabel(): string
    {
        return __('Messages');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Messages');
    }

    public static function getModelLabel(): string
    {
        return __('Message');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('branch_id')
                    ->label('Branch')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->options(fn() => \App\Models\Branch::pluck('name', 'id')),
                Forms\Components\MarkdownEditor::make('message')
                    ->translateLabel()
                    ->disableToolbarButtons(
                        ['attachFiles',]

                    )
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\MarkdownEditor::make('answer')
                    ->hiddenOn('create')
                    ->translateLabel()
                    ->disableToolbarButtons(
                        ['attachFiles',]
                    )
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('branch_name')
                    ->label('Branch Name')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('message')
                    ->translateLabel()
                    ->html()->words(10),

                IconColumn::make('answer')
                    ->label('Answered')
                    ->translateLabel()
                    ->default(fn($record) => $record->answer ? 1 : 0)
                    ->boolean()


            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
//            'create' => Pages\CreateMessage::route('/create'),
//            'view' => Pages\ViewMessage::route('/{record}'),
//            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
