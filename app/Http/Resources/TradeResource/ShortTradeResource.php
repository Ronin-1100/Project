<?php

namespace App\Http\Resources\TradeResource;

use App\Http\Resources\ProductResource\ShortProductResource;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Trade
 */
class ShortTradeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ShortProductResource::make($this->whenLoaded('product', default: null)),
            'count' => $this->count,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'promo_id' => $this->promo_id,
        ];
    }
}
