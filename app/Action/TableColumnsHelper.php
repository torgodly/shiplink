<?php

namespace App\Action;

use App\Filament\Office\Resources\PackageResource;
use App\Tables\Columns\Rating;
use App\Tables\Columns\RatingColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class TableColumnsHelper
{

    public static function PackageColumns()
    {
        return [
            TextColumn::make('code')
                ->label('Package Code')
                ->translateLabel()
                ->searchable()
                ->url(fn($record) => PackageResource::getUrl('view', ['record' => $record]))
                ->sortable(),
            TextColumn::make('sender_code')
                ->translateLabel()
                ->searchable()
                ->copyable()
                ->copyMessage(__('Sender Code copied'))
                ->sortable(),
            TextColumn::make('receiver_code')
                ->translateLabel()
                ->searchable()
                ->copyable()
                ->copyMessage(__('Receiver Code copied'))
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
                ->badge()
                ->formatStateUsing(fn(string $state): string => __($state))
                ->searchable(),
            RatingColumn::make('rating')
                ->sortable()
                ->translateLabel()
                ->label('Rating'),
            IconColumn::make('is_refrigerated')
                ->label('Refrigerated')
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
                    'OutForDelivery' => 'yellow',
                    'Processing' => 'purple',
                    'InTransit' => 'orange',
                    'WaitingForPickup' => 'secondary',
                    'Delivered' => 'green',
                    'Returned' => 'danger',
                    default => 'gray',
                })
                ->searchable(),

        ];
    }
}
