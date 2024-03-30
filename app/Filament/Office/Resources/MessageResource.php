<?php

namespace App\Filament\Office\Resources;

use App\Filament\Office\Resources\MessageResource\Pages;
use App\Filament\Office\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->translateLabel()
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
                Tables\Actions\Action::make('answer')
                    ->translateLabel()
                    ->form([
                        MarkdownEditor::make('message')
                            ->disabled()
                            ->translateLabel()
                            ->disableToolbarButtons(
                                ['attachFiles',]
                            )
                            ->columnSpanFull(),
                        MarkdownEditor::make('answer')
                            ->translateLabel()
                            ->disableToolbarButtons(
                                ['attachFiles',]
                            )
                            ->columnSpanFull(),
                    ])->fillForm(fn(Message $record): array => [
                        'message' => $record->message,
                        'answer' => $record->answer,
                    ])->action(function (Message $record, array $data) {
                        $record->update($data);
                        Notification::make()
                            ->title(__('Message Answered'))
                            ->icon('tabler-check')
                            ->iconColor('success')
                            ->color('success')
                            ->send();
                        Notification::make()
                            ->title(__('Your Message is Answered'))
                            ->icon('tabler-check')
                            ->iconColor('success')
                            ->color('success')
                            ->sendToDatabase($record->user);
                    })->label(fn(Message $record) => $record->answer ? 'Edit Answer' : 'Answer The Message'),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('branch_id')
                    ->label('Branch')
                    ->translateLabel()
                    ->columnSpanFull()
                    ->options(fn() => \App\Models\Branch::pluck('name', 'id')),
                MarkdownEditor::make('message')
                    ->translateLabel()
                    ->disableToolbarButtons(
                        ['attachFiles',]

                    )
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                MarkdownEditor::make('answer')
                    ->hiddenOn('create')
                    ->translateLabel()
                    ->disableToolbarButtons(
                        ['attachFiles',]
                    )
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return parent::infolist($infolist->schema([
            TextEntry::make('branch_name')->label('Branch Name')->translateLabel()->columnSpanFull()->size(TextEntry\TextEntrySize::Large),
            TextEntry::make('message')->translateLabel()->columnSpanFull()->markdown()->size(TextEntry\TextEntrySize::Large),
            TextEntry::make('answer')->translateLabel()->columnSpanFull()->markdown()->size(TextEntry\TextEntrySize::Large),
        ])); // TODO: Change the autogenerated stub
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('branch_id', \Auth::user()->managedbranch->id); // TODO: Change the autogenerated stub
    }
}
