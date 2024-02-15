<?php

namespace App\Filament\User\Pages;

use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
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
                TextColumn::make('sender_code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
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
                TextColumn::make('status')
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
            ->filters([
                SelectFilter::make('status')
                    ->translateLabel()
                    ->options(collect(ShippingStatus::array())->map(fn($value, $key) => __($key))->toArray())
            ])
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
                    InvoiceAction::make('Invoice')
                        ->translateLabel()
                        ->icon('tabler-file-invoice')
                        ->firstParty('Sender', fn(Package $record) => $record->SenderInfo)
                        ->secondParty('Recipient', fn(Package $record) => $record->ReceiverInfo)
                        ->status('Paid')
                        ->serialNumber('215478')
                        ->date(now()->format('Y-m-d'))
                        ->logo(asset('images/logo.png'))
                        ->invoiceItems(fn(Package $record) => $record)
                        ->setHeadersAndColumns(['code' => 'Package Code', 'weight' => 'Weight', 'price' => 'Price',])
                        ->subTotal(fn(Package $record) => $record->price)
                        ->amountPaid(fn(Package $record) => $record->price)
                        ->balanceDue('0')
                        ->total(fn(Package $record) => $record->price)
//                or
                        ->stream()
//                    ->download('test')
                    ,


            ]);
    }


}
