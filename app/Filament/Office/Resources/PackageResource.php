<?php

namespace App\Filament\Office\Resources;

use App\Action\InvoiceActionHelper;
use App\Action\PackageFilterHelper;
use App\Action\PackageFormHelper;
use App\Action\QRCodeAction;
use App\Action\TableColumnsHelper;
use App\Filament\Office\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'tabler-package-export';

    public static function getNavigationGroup(): ?string
    {
        return __('Shipments');
    }


    /**
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('Sent Packages');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Sent Packages');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->query(Package::query()->where('sender_branch_id', auth()->user()->managedbranch->id))
            ->columns(TableColumnsHelper::PackageColumns())
            ->filters(PackageFilterHelper::setPackageFilter())
            ->actions([
                Tables\Actions\Action::make('Package Status')
                    ->label('Status')
                    ->translateLabel()
                    ->icon('tabler-settings-cog')
                    ->color('primary')
                    ->url(fn($record) => PackageResource::getUrl('show', ['record' => $record])),
                QRCodeAction::QrCodeAction(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make()->requiresConfirmation(true),
                    InvoiceActionHelper::setupInvoiceAction()->stream()
                ]),

                //change status action

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PackageFormHelper::PackageForm())
            ->columns(3);
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
