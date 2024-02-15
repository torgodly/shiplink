<?php

namespace App\Filament\Resources;

use App\Enums\BranchStatus;
use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function getModelLabel(): string
    {
        return __(parent::getModelLabel());
    }

    public static function getPluralLabel(): ?string
    {
        return __('Branches');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->translateLabel()
                    ->maxLength(255),
                Forms\Components\select::make('manager_id')
                    ->required()
                    ->translateLabel()
                    ->relationship('manager', 'name', modifyQueryUsing: fn(Builder $query) => $query->where('type', 'manager')->whereDoesntHave('mangedbrance'))
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('manager_name')
                    ->label('Manager')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->translateLabel()
                    ->label('Status')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBranches::route('/'),
//            'create' => Pages\CreateBranch::route('/create'),
//            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
