<?php

namespace App\Filament\Office\Resources;

use App\Action\InvoiceActionHelper;
use App\Action\PackageFilterHelper;
use App\Action\QRCodeAction;
use App\Action\TableColumnsHelper;
use App\Enums\ShippingMethods;
use App\Filament\Office\Resources\PackageResource\Pages;
use App\Models\Package;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


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
            ->query(Package::query()->where('sender_branch_id', auth()->user()->mangedbrance->id))
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
            ->schema([

                Forms\Components\Group::make()
                    ->schema([Forms\Components\Section::make('Label')
                        ->schema([


                            TextInput::make('sender_name')->label('Sender Name')->translateLabel()->disabled(),
                            TextInput::make('receiver_name')->label('Receiver Name')->translateLabel()->disabled(),
                            Forms\Components\Select::make('sender_code')
                                ->label('Sender Code')
                                ->translateLabel()
                                ->relationship('sender', 'sender_code', function ($get, Builder $query) {
                                    $receiverCode = $get('receiver_code');
                                    return $query->when($receiverCode, fn($q) => $q->where('receiver_code', '!=', $receiverCode));
                                })
                                ->preload()
                                ->searchable()
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('sender_name', User::where('sender_code', $state)->first()?->name))
                                ->reactive()
                                ->required(),

                            Forms\Components\Select::make('receiver_code')
                                ->label('Receiver Code')
                                ->translateLabel()
                                ->required()
                                ->relationship('receiver', 'receiver_code', function ($get, Builder $query) {
                                    $senderCode = $get('sender_code');
                                    return $query->when($senderCode, fn($q) => $q->where('sender_code', '!=', $senderCode));
                                })
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('receiver_name', User::where('receiver_code', $state)->first()?->name))
                                ->preload()
                                ->searchable()
                                ->reactive(),
                            Forms\Components\MarkdownEditor::make('description')
                                ->columnSpanFull(),

                        ])->columns(2),

                        Forms\Components\Section::make('Label')
                            ->schema([
                                Forms\Components\Select::make('sender_branch_id')
                                    ->label('Sender Branch')
                                    ->required()
                                    ->relationship('senderBranch', 'name', function ($get, Builder $query) {
                                        $receiverBranch = $get('receiver_branch_id');
                                        return $query->when($receiverBranch, fn($q) => $q->where('id', '!=', $receiverBranch));
                                    })
                                    ->default(fn() => !auth()->user()->is_admin ? auth()->user()->mangedbrance->id : null)
                                    ->searchable()
                                    ->preload()
                                    ->searchable()
                                    ->disabled(fn() => !auth()->user()->is_admin)
                                    ->dehydrated(),

                                Forms\Components\Select::make('receiver_branch_id')
                                    ->label('Receiver Branch')
                                    ->required()
                                    ->relationship('receiverBranch', 'name', function ($get, Builder $query) {
                                        $senderBranch = $get('sender_branch_id');
                                        return $query->when($senderBranch, fn($q) => $q->where('id', '!=', $senderBranch));
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->searchable(),

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
                                Forms\Components\Toggle::make('fast_shipping')
                                    ->label('Fast Shipping')
                                    ->onIcon('tabler-brand-speedtest')
                                    ->offIcon('tabler-brand-speedtest')
                                    ->helperText('Do you want to ship the package fast?')
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
