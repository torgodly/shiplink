<?php

namespace App\Livewire\Package;

use App\Enums\ShippingMethods;
use App\Forms\Components\ViewPrice;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Calculator extends Component implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    public function render()
    {
        return view('livewire.package.calculator');
    }
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form

            ->schema([
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

                    ])
            ])
            ->statePath('data');
    }
}
