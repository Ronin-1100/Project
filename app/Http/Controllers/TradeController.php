<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trade\SearchRequest;
use App\Http\Requests\Trade\CreateRequest;
use App\Http\Requests\Trade\UpdateRequest;
use App\Http\Resources\TradeResource\ShortTradeResource;
use App\Http\Resources\TradeResource\TradeResource;
use App\Models\Trade;
use App\Services\TradeService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TradeController extends Controller
{
    public function __construct(
        private readonly TradeService $tradeService
    ) {
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        return ShortTradeResource::collection(
            $this->tradeService->paginate($request->validated())
        );
    }

    public function show(Trade $trade): TradeResource
    {
       $trade->load(['product', 'user', 'promotion']);

        return new TradeResource($trade);
    }

    public function store(CreateRequest $request): TradeResource
    {
        return new TradeResource(
            $this->tradeService->create($request->validated())
        );
    }

    public function update(Trade $trade, UpdateRequest $request): TradeResource
    {
        return new TradeResource(
            $this->tradeService->update($trade, $request->validated())
        );
    }

    public function destroy(Trade $trade): void
    {
        $this->tradeService->delete($trade);
    }
}
