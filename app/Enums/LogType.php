<?php

namespace App\Enums;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\Refund;
use App\Models\Trade;
use App\Models\User;

enum LogType: int
{
    case Product = 1;
    case Refund = 2;
    case Promotion = 3;
    case User = 4;
    case Trade = 5;

    public function getConnectedClass(): string
    {
        return match ($this) {
            self::Product => Product::class,
            self::Refund => Refund::class,
            self::Promotion => Promotion::class,
            self::User => User::class,
            self::Trade => Trade::class,
        };
    }
}
