<?php

namespace App\Observers;

use App\Models\Trade;

class TradeObserver
{
    public function deleted(Trade $trade): void
    {
        $trade->logs()->delete([
            'description' => 'Trade deleted',
        ]);
    }

    public function created(Trade$trade): void
    {
        $trade->logs()->create([
            'description' => 'Trade created',
        ]);
    }

    public function updated(Trade $trade): void
    {
        $trade->logs()->update([
            'description' => 'Trade updated',
        ]);
    }


}
