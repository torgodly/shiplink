<?php

namespace App\Filament\Office\Pages;

use App\Action\InvoiceActionHelper;
use App\Action\PackageFilterHelper;
use App\Action\QRCodeAction;
use App\Action\TableColumnsHelper;
use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
use App\Models\Package;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\ViewAction;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ReceivedPackages extends Page implements HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'tabler-package-import';

    protected static string $view = 'filament.office.pages.received-packages';

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
            ->defaultSort('created_at', 'desc')
            ->query(Package::query()->where('receiver_branch_id', \Auth::user()->managedbranch?->id)->whereNot('status', ShippingStatus::Pending))
            ->columns(TableColumnsHelper::PackageColumns())
            ->filters(PackageFilterHelper::setPackageFilter())
            ->actions([
                Action::make('Package Status')
                    ->label('Status')
                    ->translateLabel()
                    ->icon('tabler-settings-cog')
                    ->color('primary')
                    ->url(fn($record) => PackageResource::getUrl('show', ['record' => $record])),
                QRCodeAction::QrCodeAction(),
                ActionGroup::make([
                    ViewAction::make()->requiresConfirmation(true)
                        ->url(fn($record) => PackageResource::getUrl('view', ['record' => $record])),

                    InvoiceActionHelper::setupInvoiceAction()->stream()

                ]),


            ]);
    }


    public function getHeading(): string|Htmlable
    {
        return __(parent::getHeading());
    }

}
