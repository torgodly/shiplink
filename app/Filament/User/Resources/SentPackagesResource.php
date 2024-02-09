<?php

namespace App\Filament\User\Resources;

use App\Enums\ShippingMethods;
use App\Enums\ShippingStatus;
use App\Filament\User\Resources\SentPackagesResource\Pages;
use App\Models\Package;
use App\Tables\Actions\InvoiceAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Columns\RatingStarColumn;
use Illuminate\Database\Eloquent\Builder;

class SentPackagesResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'tabler-package-export';

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

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Package Code')
                    ->translateLabel()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Color code copied')
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
                Tables\Columns\IconColumn::make('hazardous')
                    ->translateLabel()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('insurance')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __($state))
                    ->color(fn(string $state): string => match ($state) {
                        __('Pending') => 'green',
                        'InTransit' => 'blue',
                        'OutForDelivery' => 'yellow',
                        'WaitingForPickup' => 'orange',
                        'Delivered' => 'green',
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->requiresConfirmation(true),
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
                ]),

                //change status action

            ])
            ->bulkActions([

            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Group::make()
                    ->schema([Forms\Components\Section::make('Label')
                        ->schema([

                            Forms\Components\Select::make('sender_code')
                                ->label('Sender')
                                ->translateLabel()
                                ->relationship('sender', 'sender_code', function ($get, Builder $query) {
                                    $receiverCode = $get('receiver_code');
                                    return $query->when($receiverCode, fn($q) => $q->where('receiver_code', '!=', $receiverCode));
                                })
                                ->preload()
                                ->searchable()
                                ->reactive()
                                ->required(),

                            Forms\Components\Select::make('receiver_code')
                                ->label('Receiver')
                                ->translateLabel()
                                ->required()
                                ->relationship('receiver', 'receiver_code', function ($get, Builder $query) {
                                    $senderCode = $get('sender_code');
                                    return $query->when($senderCode, fn($q) => $q->where('sender_code', '!=', $senderCode));
                                })
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('sender_code', \Auth::user()->sender_code);
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
            'index' => Pages\ListSentPackages::route('/'),
//            'create' => Pages\CreateSentPackages::route('/create'),
//            'edit' => Pages\EditSentPackages::route('/{record}/edit'),
            'view' => Pages\ViewPackage::route('/{record}'),
        ];
    }


}
