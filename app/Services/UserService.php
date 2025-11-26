<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function paginate(array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;
        $withDeleted = $searchData['with_deleted'] ?? false;

        $query = $withDeleted ?  User::withTrashed() : User::query();

        return $query
            ->tap(fn(Builder $query) => $this->filter($query, $searchData))
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function create(array $createData): User
    {
        return User::query()->create($createData);
    }

    public function update(User $user, array $updateData): User
    {
        $user->update($updateData);

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function filter(Builder $query, array $searchData): Builder
    {
        return $query
            ->when(
                isset($searchData['name']),
                fn(Builder$query) => $query->where('name', 'like', '%' . $searchData['name'] . '%')
            )
            ->when(
                isset($searchData['email']),
                fn(Builder $query) => $query->where('email', 'like' . $searchData['email'] . '%')
            )
            ->when(
                isset($searchData['product_id']),
                fn(Builder $query) => $query->whereHas(
                    'trades',
                    fn(Builder $query) => $query->where('product_id', $searchData['product_id'])
                )
            );
    }
}
