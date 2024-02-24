<?php

namespace App\Http\Responses\Auth\Contracts;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\LoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends LoginResponse
{

    public function toResponse($request): RedirectResponse|Redirector
    {
        if (Filament::auth()->user()->is_manager) {
            return redirect('/office');
        }

        if (Filament::auth()->user()->is_admin) {
            return redirect('/admin');
        }

        if (Filament::auth()->user()->is_user) {
            return redirect('/user');
        }
        return redirect('/login');
//        return redirect()->intended(Filament::getUrl());
    }

}
