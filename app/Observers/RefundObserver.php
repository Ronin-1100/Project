<?php

namespace App\Observers;

use App\Models\Refund;

class RefundObserver
{
    public function deleted(Refund$refund): void
    {
        $refund->logs()->delete([
            'description' => 'Refund deleted',
        ]);
    }

    public function created(Refund$refund): void
    {
        $refund->logs()->create([
            'description' => 'Refund created',
        ]);
    }
    public function updated(Refund$refund): void
    {
        $refund->logs()->update([
            'description' => 'Refund updated',
        ]);
    }


}
