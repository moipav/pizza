<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\ProductSize;

class CalculateCartItemPrice
{
    public function execute(ProductSize $productSize)
    {
        return round(
            $productSize->product->price * $productSize->product_adjustment, 2
        );
    }
}
