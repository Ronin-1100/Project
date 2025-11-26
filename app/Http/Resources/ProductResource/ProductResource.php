<?php

namespace App\Http\Resources\ProductResource;

use App\Http\Resources\TradeResource\ShortTradeResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'count'=> $this->count,
            'price'=> $this->price,
            'trades'=> ShortTradeResource::collection($this->whenLoaded('trades', default: [] )),
        ];
    }
}
