<?php

namespace App\Http\Resources\ProductResource;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ShortProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'count'=>$this->count,
            'price'=>$this->price,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
