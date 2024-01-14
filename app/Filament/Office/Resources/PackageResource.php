<?php

namespace App\Filament\Office\Resources;

use App\Enums\ShippingMethods;
use App\Filament\Office\Resources\PackageResource\Pages;
use App\Filament\Office\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('sender_branch_id')
                    ->default(auth()->user()->mangedbrance?->id)->disabled(fn() => auth()->user()->is_admin),
                Forms\Components\Group::make()
                    ->schema([Forms\Components\Section::make('Label')
                        ->schema([
                            Forms\Components\Select::make('sender_code')
                                ->relationship('sender', 'sender_code')
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('receiver_code')
                                ->required()
                                ->relationship('receiver', 'receiver_code')
                                ->preload()
                                ->searchable(),
                            Forms\Components\MarkdownEditor::make('description')
                                ->columnSpanFull(),

                        ])->columns(2),

                        Forms\Components\Section::make('Label')
                            ->schema([
                                Forms\Components\Select::make('receiver_branch_id')
                                    ->label('Receiver Branch')
                                    ->required()
                                    ->relationship('senderBranch', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->searchable(),
                                Forms\Components\Select::make('sender_branch_id')
                                    ->label('Sender Branch')
                                    ->required()
                                    ->relationship('receiverBranch', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->searchable()
                                    ->disabled(fn() => auth()->user()->is_admin)
                                    ->hidden(fn() => auth()->user()->is_admin),
                                Forms\Components\Select::make('payment_method')
                                    ->options(collect(['cash' => 'Cash', 'credit' => 'Credit'])->map(fn($value, $key) => __($value))->toArray())
                                    ->required(),
                            ]),

                    ])->columnSpan(['lg' => 2]),


                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_refrigerated')
                                    ->label('Refrigerated')
                                    ->onIcon('tabler-snowflake')
                                    ->offIcon('tabler-sun')
                                    ->onColor('sky')
                                    ->helperText('Is the package refrigerated?')
                                    ->required(),
                                Forms\Components\Toggle::make('fragile')
                                    ->label('Fragile')
                                    ->onIcon('carbon-fragile')
                                    ->offIcon('tabler-artboard')
                                    ->helperText('Is the package fragile?')
                                    ->required(),
                                Forms\Components\Toggle::make('hazardous')
                                    ->label('Hazardous')
                                    ->onIcon('tabler-biohazard')
                                    ->offIcon('tabler-leaf')
                                    ->helperText('Is the package hazardous?')
                                    ->required(),
                                Forms\Components\Toggle::make('insurance')
                                    ->label('Insurance')
                                    ->onIcon('tabler-shield-check')
                                    ->offIcon('tabler-shield-x')
                                    ->helperText('Do you want to insure the package?')
                                    ->required(),

                            ])->columns(),
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\TextInput::make('weight')
                                    ->label('Weight')
                                    ->required()
                                    ->prefix('kg')
                                    ->numeric(),
                                Forms\Components\TextInput::make('height')
                                    ->label('Height')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('width')
                                    ->label('Width')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('length')
                                    ->label('Length')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Select::make('shipping_method')
                                    ->label('Shipping Method')
                                    ->options(collect(ShippingMethods::array())->map(fn($value, $key) => __($value))->toArray())
                                    ->columnSpanFull(),
                            ])->columns(2),

                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender_code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver_code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('senderBranch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiverBranch.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dimensions')
                    ->numeric(),
                Tables\Columns\TextColumn::make('weight')
                    ->suffix(' kg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_refrigerated')
                    ->searchable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('fragile')
                    ->searchable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('hazardous')
                    ->searchable()
                    ->boolean(),
                Tables\Columns\IconColumn::make('insurance')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'Out for Delivery' => 'warning',
                        'Delivered' => 'success',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_method')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()->requiresConfirmation(true),
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
            'view' => Pages\ViewPackage::route('/{record}'),
        ];
    }
}
