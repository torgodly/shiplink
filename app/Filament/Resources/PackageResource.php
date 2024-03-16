<?php

namespace App\Filament\Resources;

use App\Action\InvoiceActionHelper;
use App\Action\PackageFilterHelper;
use App\Action\PackageFormHelper;
use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers;
use App\Models\Package;
use App\Tables\Columns\RatingColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'tabler-package';

    public static function getNavigationGroup(): ?string
    {
        return __('Shipments');
    }


    /**
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('Packages');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Packages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PackageFormHelper::PackageForm())
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Package Code')
                    ->translateLabel()
                    ->searchable()
                    ->url(fn($record) => PackageResource::getUrl('view', ['record' => $record]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender_code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver_code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->sortable(),
                Tables\Columns\TextColumn::make('senderBranch.name')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiverBranch.name')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dimensions')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('weight')
                    ->translateLabel()
                    ->suffix(' kg')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_method')
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->label('Shipping Method')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_refrigerated')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('fragile')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('fast_shipping')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')->sortable()
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->color(fn(string $state): string => match ($state) {
                        'OutForDelivery' => 'yellow',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
                        'Returned' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                RatingColumn::make('rating')
                    ->sortable()
                    ->translateLabel()
                    ->label('Rating'),

            ])
            ->filters(PackageFilterHelper::setPackageFilter())
            ->actions([
                ActionGroup::make([
                    Tables\Actions\Action::make('Package Status')
                        ->label('Status')
                        ->translateLabel()
                        ->icon('tabler-settings-cog')
                        ->color('primary')
                        ->url(fn($record) => \App\Filament\Office\Resources\PackageResource::getUrl('show', ['record' => $record])),
                    Tables\Actions\ViewAction::make()->requiresConfirmation(true)->color('primary'),
                    InvoiceActionHelper::setupInvoiceAction()->stream()
                ])

                //change status action

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
            'show' => Pages\ShowProgress::route('/{record}/show'),
        ];
    }
}
