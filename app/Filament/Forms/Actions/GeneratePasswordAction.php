<?php

namespace App\Filament\Forms\Actions;

use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Component;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class GeneratePasswordAction extends FormAction
{
    public static function getDefaultName(): ?string
    {
        return 'generatePassword';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon('tabler-password-user')
            ->color('primary')
            ->tooltip(__('Generate Password'))
            ->action(function (Set $set, Component $component) {
                $set(
                    $component->getStatePath(false),
                    Str::password(20)
                );
            });
    }
}
