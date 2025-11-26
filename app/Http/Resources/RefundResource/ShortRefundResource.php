<?php

namespace App\Http\Resources\RefundResource;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Refund
 */
class ShortRefundResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'count' => $this->count,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'promo_id' => $this->promo_id,
            'reason' => $this->reason,
        ];
    }
}
