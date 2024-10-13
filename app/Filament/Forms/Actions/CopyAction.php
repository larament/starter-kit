<?php

namespace App\Filament\Forms\Actions;

use App\Filament\Concerns\HasCopyable;
use Filament\Forms\Components\Actions\Action as FormAction;

class CopyAction extends FormAction
{
    use HasCopyable {
        HasCopyable::getCopyable as getDefaultCopyable;
    }

    public function getCopyable(): ?string
    {
        if ($this->copyable === null) {
            return $this->evaluate(fn ($component) => '$wire.'.$component->getStatePath());
        }

        return parent::getDefaultCopyable();
    }
}
