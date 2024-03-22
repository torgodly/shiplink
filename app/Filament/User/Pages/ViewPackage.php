<?php

namespace App\Filament\User\Pages;

use App\Enums\ShippingMethods;
use App\Models\Package;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class ViewPackage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'sent-packages/{record}/view';
    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.user.pages.view-package';
    public $record;

    public function mount(Package $record)
    {
        $this->record = $record;
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->disabled()
            ->schema([

                Group::make()
                    ->schema([Section::make('Label')
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
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('sender_name', User::where('sender_code', $state)->first()->name))
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
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('receiver_name', User::where('receiver_code', $state)->first()->name))
                                ->preload()
                                ->searchable()
                                ->reactive(),
                            MarkdownEditor::make('description')
                                ->columnSpanFull(),

                        ])->columns(2),

                        Section::make('Label')
                            ->schema([
                                Select::make('sender_branch_id')
                                    ->label('Sender Branch')
                                    ->required()
                                    ->relationship('senderBranch', 'name', function ($get, Builder $query) {
                                        $receiverBranch = $get('receiver_branch_id');
                                        return $query->when($receiverBranch, fn($q) => $q->where('id', '!=', $receiverBranch));
                                    })
                                    ->default(fn() => !auth()->user()->is_admin ? auth()->user()->managedbranch->id : null)
                                    ->searchable()
                                    ->preload()
                                    ->searchable()
                                    ->disabled(fn() => !auth()->user()->is_admin)
                                    ->dehydrated(),

                                Select::make('receiver_branch_id')
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
                                    ->options(collect(['cash' => 'Cash', 'credit' => 'Credit'])->map(fn($value, $key) => __($value))->toArray())
                                    ->required(),
                            ]),

                    ])->columnSpan(['lg' => 2]),


                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_refrigerated')
                                    ->label('Refrigerated')
                                    ->onIcon('tabler-snowflake')
                                    ->offIcon('tabler-sun')
                                    ->onColor('sky')
                                    ->helperText('Is the package refrigerated?')
                                    ->required(),
                                Toggle::make('fragile')
                                    ->label('Fragile')
                                    ->onIcon('carbon-fragile')
                                    ->offIcon('tabler-artboard')
                                    ->helperText('Is the package fragile?')
                                    ->required(),
                                Toggle::make('fast_shipping')
                                    ->label('Fast Shipping')
                                    ->onIcon('tabler-brand-speedtest')
                                    ->offIcon('tabler-brand-speedtest')
                                    ->helperText('Do you want to ship the package fast?')
                                    ->required(),
                                Toggle::make('insurance')
                                    ->label('Insurance')
                                    ->onIcon('tabler-shield-check')
                                    ->offIcon('tabler-shield-x')
                                    ->helperText('Do you want to insure the package?')
                                    ->required(),

                            ])->columns(),
                        Section::make('Status')
                            ->schema([
                                TextInput::make('weight')
                                    ->label('Weight')
                                    ->required()
                                    ->prefix('kg')
                                    ->numeric(),
                                TextInput::make('height')
                                    ->label('Height')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                TextInput::make('width')
                                    ->label('Width')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                TextInput::make('length')
                                    ->label('Length')
                                    ->prefix('cm')
                                    ->minValue(1)
                                    ->required()
                                    ->numeric(),
                                Select::make('shipping_method')
                                    ->label('Shipping Method')
                                    ->options(collect(ShippingMethods::array())->map(fn($value, $key) => __($value))->toArray())
                                    ->columnSpanFull(),
                            ])->columns(2),

                    ])->columnSpan(['lg' => 1]),
            ])->statePath('record')->model(Package::class)
            ->columns(3);
    }

}
