<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Refund;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class RefundService
{
    /**
     * @param array $createData
     * @return Refund
     * @throws \Exception
     */

    public function paginate(array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;
        $withDeleted = $searchData['with_deleted'] ?? false;

        $query = $withDeleted ?  Refund::withTrashed() : Refund::query();

        return $query
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function updateCounts(Trade $trade, int $refundQuantity): void
    {
        $trade->decrement('count', $refundQuantity);

        Product::query()
            ->where('id', $trade->product_id)
            ->increment('count', $refundQuantity);
    }

    public function create(array $createData): Refund
    {
        $tradeId = $createData['trade_id'] ?? null;

        $count = $createData['count'] ?? null;

        $trade = Trade::query()->findOrFail($tradeId);

        if($count <= 0 || $count > $trade->count) {
            throw new \Exception('Trade count error');
        }


        $refund = Refund::query()->create($createData);

        if($count == $trade->count) {
            $trade->delete();
        }

        $this -> updateCounts($trade, $count);

        $trade->refresh();


        $refund->load(['user', 'trade']);

        return $refund;
    }

    public function update(Refund $refund, array $updateData): Refund
    {
        $refund->update($updateData);

        $refund->load(['user', 'trade']);

        return $refund;
    }

    public function delete(Refund $refund): void
    {
        $refund->delete();
    }

    public function filter(Builder $query, array $searchData): Builder
    {
        return $query
            ->when(
                isset($searchData['count']),
                fn(Builder $query) => $query->where('count', $searchData['count'])
            )
            ->when(
                isset($searchData['reason']),
                fn(Builder $query) => $query->where('reason', $searchData['reason'])
            )
            ->when(
                isset($searchData['price']),
                fn(Builder $query) => $query->where('price', $searchData['price'])
            )
            ->when(
                isset($searchData['trade_id']),
                fn(Builder $query) => $query->tradeId($searchData['trade_id'])
            );

    }
}
