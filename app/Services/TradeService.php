<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Promotion;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class TradeService
{
    public function paginate(array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;
        $withDeleted = $searchData['with_deleted'] ?? false;

        $query = $withDeleted ?  Trade::withTrashed() : Trade::query();

        return $query
            ->with(['product', 'user', 'promotion'])
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function decreaseProductCount(int $productId, int $count): void
    {
        Product::query()->where('id', $productId)->decrement('count', $count);
    }

    public function create(array $createData): Trade
    {
        $count = $createData['count'] ?? null;
        $productId = $createData['product_id'] ?? null;

        $product = Product::query()->findOrFail($productId);

        if ($count <= 1 || $count > $product->count) {
            throw new \Exception('Product count error');
        }

        $promo = null;
        if (!empty($createData['promotion_id'])) {
            $promo = Promotion::query()->findOrFail($createData['promotion_id']);
        }

        $basePrice = $product->price * $count;

        $finalPrice = $basePrice;

        if ($promo) {
            if (!empty($promo->discount_sum) && $promo->discount_sum > 0) {
                $finalPrice -= $promo->discount_sum;
            }

            if (!empty($promo->discount_percent) && $promo->discount_percent > 0) {
                $finalPrice -= $basePrice * ($promo->discount_percent / 100);
            }

            if ($finalPrice < 0) {
                $finalPrice = 0;
            }
        }

        $createData['price'] = $finalPrice;

        $trade = Trade::query()->create($createData);

        $this->decreaseProductCount($product->id, $count);

        $trade->load(['product', 'user', 'promotion']);

        return $trade;
    }


    public function update(Trade $trade, array $updateData): Trade
    {
        $trade->update($updateData);

        $trade->load(['product', 'user', 'promotion']);

        return $trade;
    }


    public function delete(Trade $trade): void
    {
        $trade->delete();
    }

    public function filter(Builder $query, array $searchData): Builder
    {
        return $query
            ->when(
                isset($searchData['count']),
                fn(Builder $query) => $query->where('count', $searchData['count'])
            )
            ->when(
                isset($searchData['price']),
                fn(Builder $query) => $query->where('price', $searchData['price'])
            )
            ->when(
                isset($searchData['product_id']),
                fn(Builder $query) => $query->productId($searchData['product_id'])
            );
    }

}
