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
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

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
                    ->unique('users', 'email', ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                PhoneInput::make('phone')
                    ->validateFor(
                        lenient: true, // default: false
                    )
                    ->required()
                    ->columnSpanFull()
                    ->unique('users', 'phone', ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->translateLabel()
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->translateLabel()
                    ->password()
                    ->required()
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->translateLabel()
                    ->copyable()
                    ->copyMessage(__('Copied!'))
                    ->searchable(),
                PhoneColumn::make('phone')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->badge()
                    ->searchable(),
                //sender code
                Tables\Columns\TextColumn::make('sender_code')
                    ->translateLabel()
                    ->searchable(),
                //receiver code
                Tables\Columns\TextColumn::make('receiver_code')
                    ->translateLabel()
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->translateLabel()
                    ->options(
                        [
                            'user' => 'user',
                            'admin' => 'admin',
                            'manager' => 'manager'

                        ]
                    )
            ])
            ->actions([
                Tables\Actions\EditAction::make()->requiresConfirmation(true)->modalWidth('2xl')->modalIcon('heroicon-o-users'),
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
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'user');
    }

}
