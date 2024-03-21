<?php

namespace App\Action;

use App\Enums\ShippingMethods;
use App\Forms\Components\ViewPrice;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class PackageFormHelper
{

    public static function PackageForm()
    {
        return [

            Group::make()
                ->schema([Section::make(__('Package Information'))
                    ->schema([
                        TextInput::make('sender_name')->label('Sender Name')->translateLabel()->disabled(),
                        TextInput::make('receiver_name')->label('Receiver Name')->translateLabel()->disabled(),
                        Select::make('sender_code')
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

                        Select::make('receiver_code')
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
                        MarkdownEditor::make('description')
                            ->translateLabel()
                            ->columnSpanFull(),

                    ])->columns(2),

                    Section::make(__('Branches'))
                        ->schema([
                            Select::make('sender_branch_id')
                                ->translateLabel()
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

                            Select::make('receiver_branch_id')
                                ->translateLabel()
                                ->label('Receiver Branch')
                                ->required()
                                ->relationship('receiverBranch', 'name', function ($get, Builder $query) {
                                    $senderBranch = $get('sender_branch_id');
                                    return $query->when($senderBranch, fn($q) => $q->where('id', '!=', $senderBranch));
                                })
                                ->searchable()
                                ->preload()
                                ->searchable(),

                            Select::make('payment_method')
                                ->label('Payment Method')
                                ->translateLabel()
                                ->options(collect(['cash' => 'Cash', 'credit' => 'Credit'])->map(fn($value, $key) => __($value))->toArray())
                                ->required(),
                        ]),

                ])->columnSpan(['lg' => 2]),


            Group::make()
                ->schema([
                    Section::make(__('Price'))
                        ->schema([
                            ViewPrice::make('price')
                                ->hiddenLabel()
                                ->translateLabel()
                                ->columnSpanFull(),
                        ])->columns(),
                    Section::make(__('Options'))
                        ->schema([
                            Toggle::make('is_refrigerated')
                                ->live()
                                ->translateLabel()
                                ->label('Refrigerated')
                                ->onIcon('tabler-snowflake')
                                ->offIcon('tabler-sun')
                                ->onColor('sky')
                                ->helperText(__('Is the package refrigerated?'))
                                ->required(),
                            Toggle::make('fragile')
                                ->live()
                                ->translateLabel()
                                ->label('Fragile')
                                ->onIcon('carbon-fragile')
                                ->offIcon('tabler-artboard')
                                ->helperText(__('Is the package fragile?'))
                                ->required(),
                            Toggle::make('fast_shipping')
                                ->live()
                                ->translateLabel()
                                ->label('Fast Shipping')
                                ->onIcon('tabler-brand-speedtest')
                                ->offIcon('tabler-brand-speedtest')
                                ->helperText(__('Do you want to ship the package fast?'))
                                ->required(),
                            Toggle::make('insurance')
                                ->live()
                                ->translateLabel()
                                ->label('Insurance')
                                ->onIcon('tabler-shield-check')
                                ->offIcon('tabler-shield-x')
                                ->helperText(__('Do you want to insure the package?'))
                                ->required(),

                        ])->columns(),
                    Section::make(__('Dimensions'))
                        ->schema([
                            TextInput::make('weight')
                                ->live()
                                ->label('Weight')
                                ->translateLabel()
                                ->required()
                                ->prefix('kg')
                                ->numeric(),
                            TextInput::make('height')
                                ->live()
                                ->label('Height')
                                ->translateLabel()
                                ->prefix('cm')
                                ->minValue(1)
                                ->required()
                                ->numeric(),
                            TextInput::make('width')
                                ->live()
                                ->label('Width')
                                ->translateLabel()
                                ->prefix('cm')
                                ->minValue(1)
                                ->required()
                                ->numeric(),
                            TextInput::make('length')
                                ->live()
                                ->label('Length')
                                ->translateLabel()
                                ->prefix('cm')
                                ->minValue(1)
                                ->required()
                                ->numeric(),
                            Select::make('shipping_method')
                                ->live()
                                ->translateLabel()
                                ->label('Shipping Method')
                                ->options(collect(ShippingMethods::array())->map(fn($value, $key) => __($value))->toArray())
                                ->columnSpanFull(),
                        ])->columns(2),

                ])->columnSpan(['lg' => 1]),
        ];
    }
}
