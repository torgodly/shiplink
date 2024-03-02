<?php

namespace App\Filament\User\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Register extends BaseRegister
{


    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }


    //phone
    protected function getPhoneFormComponent(): Component
    {
        return PhoneInput::make('phone')
            ->validateFor(
                lenient: true, // default: false
            )
            ->required()
            ->unique('users', 'phone', ignoreRecord: true)
            ->defaultCountry('US')
            ;
    }
}
