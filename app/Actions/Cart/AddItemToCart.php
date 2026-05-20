<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class AddItemToCart
{
    public function __construct(
        private readonly CalculateCartItemPrice $calculatePrice,

    )
    {
    }

    /**
     * Добавляем товар в корзину или увеличиваем количество
     */
    public function execute(Cart $cart, ProductSize $productSize, int $quantity): CartItem
    {
        $pricePerUnit = $this->calculatePrice->execute($productSize);

        $cartItem = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_size_id' => $productSize->id,
            ]
        );

        $cartItem->fill([
            'product_id' => $productSize->product->id,
            'quantity' => $cartItem->exists ? $cartItem->quantity + $quantity : $quantity,
            'price_per_unit' => $pricePerUnit,
        ]);

        $cartItem->save(); // Eloquent сам проставит cart_id, created_at, updated_at

        return $cartItem;
    }
}
