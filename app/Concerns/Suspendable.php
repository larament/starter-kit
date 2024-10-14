<?php

namespace App\Concerns;

use App\Notifications\AccountSuspendedNotification;
use App\Notifications\AccountUnsuspendedNotification;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait Suspendable
{
    /**
     * Account is banned for lifetime.
     */
    protected function isBanned(): Attribute
    {
        return Attribute::get(fn () => $this->suspended_at && ! $this->suspension_ends_at);
    }

    /**
     * Account is suspended for some time.
     */
    protected function isSuspended(): Attribute
    {
        return Attribute::get(fn () => $this->suspended_at && $this->suspension_ends_at?->isFuture());
    }

    /**
     * Suspend account and notify them.
     */
    public function suspend(string $reason, CarbonInterface $ends_at = null): void
    {
        $this->update([
            'suspended_at' => now(),
            'suspension_reason' => $reason,
            'suspension_ends_at' => $ends_at,
        ]);

        $this->notify(new AccountSuspendedNotification($this));
    }

    /**
     * Un-suspend account and notify them.
     */
    public function unsuspend(): void
    {
        if (! $this->suspended_at) {
            return;
        }

        $this->update([
            'suspended_at' => null,
            'suspension_reason' => null,
            'suspension_ends_at' => null,
        ]);

        $this->notify(new AccountUnsuspendedNotification($this));
    }
}
