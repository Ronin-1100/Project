<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function paginate(array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;
        $withDeleted = $searchData['with_deleted'] ?? false;

        $query = $withDeleted ?  Product::withTrashed() : Product::query();

        return $query
            ->with(['trades'])
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function create(array $createData): Product
    {
        return Product::query()->create($createData);
    }

    public function update(Product $product, array $updateData): Product
    {
        $product->update($updateData);
        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function filter(Builder $query, array $searchData): Builder
    {
        return $query
            ->when(
                isset($searchData['price']),
                fn(Builder $query) => $query->where('price', $searchData['price'])
            )
            ->when(
                isset($searchData['name']),
                fn(Builder $query) => $query->where('name', $searchData['name'])
            )
            ->when(
                isset($searchData['count']),
                fn(Builder $query) => $query->where('count', $searchData['count'])
            )
            ->when(
                isset($searchData['user_id']),
                fn(Builder $query) => $query->userId($searchData['user_id'])
            );
    }
}
