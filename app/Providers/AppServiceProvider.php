<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\Refund;
use App\Models\Trade;
use App\Models\User;
use App\Observers\ProductObserver;
use App\Observers\PromotionObserver;
use App\Observers\RefundObserver;
use App\Observers\TradeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Promotion::observe(PromotionObserver::class);
        Refund::observe(RefundObserver::class);
        Trade::observe(TradeObserver::class);
        User::observe(UserObserver::class);
    }
}
