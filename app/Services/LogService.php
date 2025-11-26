<?php

namespace App\Services;

use App\Enums\LogType;
use App\Models\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class LogService
{
    public function paginate(LogType $type, array $searchData = []): LengthAwarePaginator
    {
        $page = $searchData['page'] ?? 1;
        $perPage = $searchData['per_page'] ?? 20;

        return Log::query()
            ->when(
                isset($searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', $searchData['sort_type']),
                fn(Builder $query) => $query->orderBy('id', 'asc')
            )
            ->whereHasMorph(
                'loggable',
                [$type->getConnectedClass()],
                fn(Builder $query) => match ($type) {
                    LogType::Product => resolve(ProductService::class)->filter($query, $searchData),
                    LogType::Refund => resolve(RefundService::class)->filter($query, $searchData),
                    LogType::Promotion => resolve(PromotionService::class)->filter($query, $searchData),
                    LogType::User => resolve(UserService::class)->filter($query, $searchData),
                    LogType::Trade => resolve(TradeService::class)->filter($query, $searchData),

                    default => throw new \Exception('Unexpected match value'),
                }
            )
            ->paginate(perPage: $perPage, page: $page);
    }

    public function update(Log $log, array $updateData): Log
    {
        $log->update($updateData);

        return $log;
    }

    public function delete(Log $log): void
    {
        $log->delete();
    }
}
