<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Cart\AddItemToCart;
use App\Actions\Cart\UpdateCartItemQuantity;
use App\Contracts\CartResolver;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\ProductSize;
use http\Env\Response;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    public function __construct(
        private readonly AddItemToCart          $addItemToCart,
        private readonly UpdateCartItemQuantity $updateCartItemQuantity,
        private readonly CartResolver           $cartResolver,
    )
    {

    }

    public function index(): CartResource
    {
        $cart = $this->cartResolver->resolve();
        $cart->load('items.productSize.product');

        return CartResource::make($cart);
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $cart = $this->cartResolver->resolve();

        $productSize = ProductSize::with('product')->findOrFail($request->product_size_id);

        $this->addItemToCart->execute($cart, $productSize, $request->quantity);

        return response()->json([
            'message' => 'Товар добавлен',
            'data' => new CartResource($cart->load('items.productSize.product'))
        ], 201);
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): JsonResponse
    {
        $cart = $this->cartResolver->resolve();

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        $this->updateCartItemQuantity->execute($cartItem, $request->quantity);

        return response()->json([
            'message' => 'Количество обновлено',
            'data' => new CartResource($cart->load('items.productSize.product'))
        ]);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        $cart = $this->cartResolver->resolve();

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['message' => 'Доступ запрещен']);
        }

        $cartItem->delete();

        return response()->json([
            'message' => 'Товар удален из корзины',
            'data' => new CartResource($cart->load('items.productSize.product'))
        ]);
    }
}
