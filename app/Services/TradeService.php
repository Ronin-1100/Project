<?php

namespace App\Services;

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

        return Trade::query()
            ->with(['product', 'user', 'promotion'])
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function create(array $createData): Trade
    {
        $trade = Trade::query()->create($createData);

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
//TODO пример
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
