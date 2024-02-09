<?php

namespace App\Filament\Office\Resources;

use App\Filament\Office\Resources\UserResource\Pages;
use App\Filament\Office\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Users');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->translateLabel()
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->translateLabel()
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\select::make('type')
                    ->translateLabel()
                    ->required()
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                        'manager' => 'Manager',
                    ])->default('user')->disabled()->dehydrated(),
                Forms\Components\TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->required()->hiddenOn('edit'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->translateLabel()
                    ->password()
                    ->required()->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->searchable()
                    ->translateLabel(),
                //sender code
                Tables\Columns\TextColumn::make('sender_code')
                    ->searchable()
                    ->translateLabel(),
                //receiver code
                Tables\Columns\TextColumn::make('receiver_code')
                    ->searchable()
                    ->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->requiresConfirmation(true)->modalWidth('2xl')->modalIcon('heroicon-o-users'),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'user');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
