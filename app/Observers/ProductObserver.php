<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function deleted(Product $product): void
    {
        $product->logs()->delete([
            'description' => 'Product deleted',
        ]);
    }

    public function created(Product $product): void
    {
        $product->logs()->create([
            'description' => 'Product created',
        ]);
    }

    public function updated(Product $product): void
    {
        $product->logs()->update([
            'description' => 'Product updated',
        ]);
    }
}
