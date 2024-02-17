<?php

namespace App\Filament\User\Pages;

use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
use App\Helper\InvoiceActionHelper;
use App\Helper\PackageFilterHelper;
use App\Models\Package;
use App\Tables\Actions\InvoiceAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SentPackages extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'tabler-package-export';

    protected static string $view = 'filament.user.pages.sent-packages';

    public static function getNavigationGroup(): ?string
    {
        return __('Shipments');
    }

    /**
     * @return int|null
     */
    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public function getHeading(): string
    {
        return __(parent::getHeading()); // TODO: Change the autogenerated stub
    }

    public static function getNavigationLabel(): string
    {
        return __(parent::getNavigationLabel());
    }



    public static function table(Table $table): Table
    {
        return $table
            ->query(Package::query()->where('sender_code', auth()->user()->sender_code))
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
                    ->sortable()
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


            ]);
    }


}
