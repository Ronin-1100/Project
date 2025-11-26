<?php

namespace App\Http\Controllers;

use App\Http\Requests\Promotion\SearchRequest;
use App\Http\Requests\Promotion\CreateRequest;
use App\Http\Requests\Promotion\UpdateRequest;
use App\Http\Resources\ProductResource\ShortProductResource;
use App\Http\Resources\PromotionResource\PromotionResource;
use App\Http\Resources\PromotionResource\ShortPromotionResource;
use App\Models\Promotion;
use App\Services\PromotionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PromotionController extends Controller
{
    public function __construct(
        private readonly PromotionService $promotionService
    ) {
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        return ShortPromotionResource::collection(
            $this->promotionService->paginate($request->validated())
        );
    }

    public function show(Promotion $promotion): PromotionResource
    {
       $promotion->load(['product', 'user']);

        return new PromotionResource($promotion);
    }

    public function store(CreateRequest $request): PromotionResource
    {
        return new PromotionResource(
            $this->promotionService->create($request->validated())
        );
    }

    public function update(Promotion $promotion, UpdateRequest $request): PromotionResource
    {
        return new PromotionResource(
            $this->promotionService->update($promotion, $request->validated())
        );
    }

    public function destroy(Promotion $promotion): void
    {
        $this->promotionService->delete($promotion);
    }
}
