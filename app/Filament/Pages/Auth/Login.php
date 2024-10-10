<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as FilamentLogin;

class Login extends FilamentLogin
{
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => config('larament.super_admin.email'),
                'password' => config('larament.super_admin.password'),
                'remember' => true,
            ]);
        }
    }
}
