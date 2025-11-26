<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\SearchRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource\ProductResource;
use App\Http\Resources\ProductResource\ShortProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        return ShortProductResource::collection(
            $this->productService->paginate($request->validated())
        );
    }

    public function show(Product $product): ProductResource
    {
        $product->load(['trades']);

        return new ProductResource($product);
    }

    public function store(CreateRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->create($request->validated())
        );
    }

    public function update(Product $product, UpdateRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->update($product, $request->validated())
        );
    }

    public function destroy(Product $product): void
    {
        $this->productService->delete($product);
    }
}
