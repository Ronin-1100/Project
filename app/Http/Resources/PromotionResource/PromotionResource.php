<?php

namespace App\Http\Resources\PromotionResource;

use App\Http\Resources\ProductResource\ShortProductResource;
use App\Http\Resources\TradeResource\ShortTradeResource;
use App\Http\Resources\UserResource\ShortUserResource;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Promotion
 */
class PromotionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ShortProductResource::make($this->whenLoaded('product', default: null)),
            'count' => $this->count,
            'price' => $this->price,
            'user' => ShortUserResource::make($this->whenLoaded('user', default: null)),
            'discount_sum' => $this->discount_sum,
            'discount_percent' => $this->discount_percent,
        ];
    }
}
