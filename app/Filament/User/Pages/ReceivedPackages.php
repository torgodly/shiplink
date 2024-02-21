<?php

namespace App\Filament\User\Pages;

use App\Enums\ShippingStatus;
use App\Action\InvoiceActionHelper;
use App\Action\PackageFilterHelper;
use App\Models\Package;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReceivedPackages extends SentPackages
{
    protected static ?string $navigationIcon = 'tabler-package-import';

    protected static string $view = 'filament.user.pages.received-packages';


    public static function table(Table $table): Table
    {
        return $table
            ->query(Package::query()->where('receiver_code', auth()->user()->receiver_code))
            ->columns([
                TextColumn::make('code')
                    ->label('Package Code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->sortable(),
                TextColumn::make('price')
                    ->label("Shipping Price")
                    ->translateLabel()
                    ->sortable(),
                TextColumn::make('receiver_code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->sortable(),
                TextColumn::make('receiverBranch.name')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dimensions')
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('weight')
                    ->translateLabel()
                    ->suffix(' kg')
                    ->sortable(),
                TextColumn::make('shipping_method')
                    ->translateLabel()
                    ->label('Shipping Method')
                    ->searchable(),
                IconColumn::make('is_refrigerated')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('fragile')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('fast_shipping')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('insurance')
                    ->translateLabel()
                    ->boolean(),
                TextColumn::make('status')->sortable()
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->color(fn(string $state): string => match ($state) {
                        'InTransit' => 'blue',
                        'OutForDelivery' => 'yellow',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
                        'Returned' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

            ])
            ->filters(PackageFilterHelper::setPackageFilter())
            ->actions([
                Action::make('Package Status')
                    ->label('Status')
                    ->translateLabel()
                    ->icon('tabler-settings-cog')
                    ->color('primary')
                    ->url(fn($record) => ShowProgress::getUrl(['record' => $record])),
                Action::make('View')->requiresConfirmation(true)
                    ->translateLabel()
                    ->icon('heroicon-o-eye')
                    ->url(fn(Package $record) => ViewPackage::getUrl(['record' => $record])),
                InvoiceActionHelper::setupInvoiceAction()->stream()
                ,]);
    }


}
