<?php

namespace App\Http\Resources\PromotionResource;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Promotion
 */
class ShortPromotionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'count' => $this->count,
            'price' =>$this->price,
            'user_id' =>$this->user_id,
            'discount_sum' =>$this->discount_sum,
            'discount_percent' =>$this->discount_percent,
        ];
    }
}
