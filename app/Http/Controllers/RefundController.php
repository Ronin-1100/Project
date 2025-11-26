<?php

namespace App\Http\Controllers;

use App\Http\Requests\Refund\SearchRequest;
use App\Http\Requests\Refund\CreateRequest;
use App\Http\Requests\Refund\UpdateRequest;
use App\Http\Resources\RefundResource\RefundResource;
use App\Http\Resources\RefundResource\ShortRefundResource;
use App\Models\Refund;
use App\Services\RefundService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class RefundController extends Controller
{
    public function __construct(
        private readonly RefundService $refundService
    ) {
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        return ShortRefundResource::collection(
            $this->refundService->paginate($request->validated())
        );
    }

    public function show(Refund $refund): RefundResource
    {
        $refund->load(['trade', 'user']);

        return new RefundResource($refund);
    }

    public function store(CreateRequest $request): RefundResource
    {
        return new RefundResource(
            $this->refundService->create($request->validated())
        );
    }

    public function update(Refund $refund, UpdateRequest $request): RefundResource
    {
        return new RefundResource(
            $this->refundService->update($refund, $request->validated())
        );
    }

    public function destroy(Refund $refund): void
    {
        $this->refundService->delete($refund);
    }
}
