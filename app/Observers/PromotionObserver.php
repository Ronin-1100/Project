<?php

namespace App\Observers;

use App\Models\Promotion;

class PromotionObserver
{
    public function deleted(Promotion $promotion): void
    {
        $promotion->logs()->delete([
            'description' => 'Promotion deleted',
        ]);
    }

    public function created(Promotion$promotion): void
    {
        $promotion->logs()->create([
            'description' => 'Promotion created',
        ]);
    }

    public function updated(Promotion $promotion): void
    {
        $promotion->logs()->update([
            'description' => 'Promotion updated',
        ]);
    }


}
