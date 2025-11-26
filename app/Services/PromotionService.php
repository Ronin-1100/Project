<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PromotionService
{
    public function paginate(array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;
        $withDeleted = $searchData['with_deleted'] ?? false;

        $query = $withDeleted ? Promotion::withTrashed() : Promotion::query();

        return Promotion::query()
            ->with(['product', 'user'])
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function create(array $createData): Promotion
    {
        $promotion = Promotion::query()->create($createData);

        $promotion->load(['product', 'user']);

        return $promotion;
    }

    public function update(Promotion $promotion, array $updateData): Promotion
    {
        $promotion->update($updateData);

        $promotion->load(['product', 'user']);

        return $promotion;
    }

    public function delete(Promotion $promotion): void
    {
        $promotion->delete();
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
                isset($searchData['discount_sum']),
                fn(Builder $query) => $query->where('discount_sum', $searchData['discount_sum'])
            )
            ->when(
                isset($searchData['discount_percent']),
                fn(Builder $query) => $query->where('discount_percent', $searchData['discount_percent'])
            )
            ->when(
                isset($searchData['product_id']),
                fn(Builder $query) => $query->productId($searchData['product_id'])
    );
    }
}
