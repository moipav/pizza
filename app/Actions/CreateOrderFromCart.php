<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CreateOrderFromCart
{
    public function __invoke(Cart $cart, array $data): Order
    {
        return DB::transaction(function () use ($cart, $data) {
            $cart->load(['items.product', 'items.productSize']);
//dd($cart->items->isEmpty());
//            if ($cart->items->isEmpty()) {
//                return to_route('cart.index')->with('error', 'Корзина пуста');
//            }

            $order = Order::create([
                'user_id' => $cart->user_id ?? null,
                'cart_id' => $cart->id,
                'status' => OrderStatus::PENDING,
                'total' => $cart->items->sum(fn($i) => $i->price_per_unit * $i->quantity),
                'delivery_address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? $cart->user()->email ?? null,
            ]);

            foreach ($cart->items as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_size_id' => $item->product_size_id,
                    'product_name' => $item->product->name,
                    'product_size_name' => $item->productSize->size_name,
                    'price' => $item->price_per_unit,
                    'quantity' => $item->quantity,
                ]);
            }

            $cart->items()->delete();

            return $order;
        });
    }
}
