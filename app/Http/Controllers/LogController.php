<?php

namespace App\Http\Controllers;

use App\Enums\LogType;
use App\Http\Requests\Log\SearchRequest;
use App\Http\Resources\LogResource\LogResource;
use App\Models\Log;
use App\Services\LogService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LogController extends Controller
{
    public function __construct(
        private readonly LogService $logService,
    ) {
    }

    public function index(int $type, SearchRequest $request): AnonymousResourceCollection
    {
        $logType = LogType::tryFrom($type);

        if (!$logType) {
            abort(404);
        }

        return LogResource::collection(
            $this->logService->paginate($logType, $request->validated())
        );
    }

    public function destroy(Log $log): void
    {
        $this->logService->delete($log);
    }
}
