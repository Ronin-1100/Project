<?php

namespace App\Http\Resources\RefundResource;

use App\Http\Resources\TradeResource\ShortTradeResource;
use App\Http\Resources\UserResource\ShortUserResource;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Refund
 */
class RefundResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'count' => $this->count,
            'user' => ShortUserResource::make($this->whenLoaded('user', default: null)),
            'price' => $this->price,
            'reason' => $this->reason,
            'trade' => ShortTradeResource::make($this->whenLoaded('trade', default: null)),
        ];
    }
}
