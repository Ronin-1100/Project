<?php

namespace App\Http\Resources\TradeResource;

use App\Http\Resources\ProductResource\ShortProductResource;
use App\Http\Resources\PromotionResource\ShortPromotionResource;
use App\Http\Resources\RefundResource\ShortRefundResource;
use App\Http\Resources\UserResource\ShortUserResource;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Trade
 */
class TradeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ShortProductResource::make($this->whenLoaded('product', default: null)),
            'count' => $this->count,
            'user' => ShortUserResource::make($this->whenLoaded('user', default: null)),
            'price' => $this->price,
            'promotion' => ShortPromotionResource::make($this->whenLoaded('promotion', default: null)),
            'refund' => ShortRefundResource::make($this->whenLoaded('refund', default: null)),
        ];
    }
}
