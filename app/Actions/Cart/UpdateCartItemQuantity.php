<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\CartItem;

class UpdateCartItemQuantity
{
    public function execute(CartItem $cartItem, int $quantity): CartItem
    {
        $pricePerUnit = $cartItem->productSize->product->price + $cartItem->productSize->price_adjustment;

        return tap($cartItem)->update([
            'quantity' => $quantity,
            'price_per_unit'=> round($pricePerUnit, 2),
        ]);
    }
}
