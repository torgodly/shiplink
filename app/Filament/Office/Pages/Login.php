<?php

namespace App\Filament\Office\Pages;

use App\Enums\BranchStatus;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();
        if (
            ($user instanceof FilamentUser) &&
            (!$user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }
        //if user is assigned to a branch,
        if ($user->mangedbrance()->exists()) {
            if ($user->mangedbrance->status === 1) {


                session()->regenerate();

                return app(LoginResponse::class);
            } else {
                Filament::auth()->logout();
                $this->throwInactiveBranchException();
            }

        } //if user is not assigned to a branch
        else {
            Filament::auth()->logout();
            $this->throwNoBranchException();
        }

    }


    //Throw exception for inactive branch
    protected function throwInactiveBranchException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('The branch you are assigned to is inactive, please contact the admin'),
        ]);
    }

    //throwNoBranchException
    protected function throwNoBranchException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('You are not assigned to any branch, please contact the admin'),
        ]);
    }
}