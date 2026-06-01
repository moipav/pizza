<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Contracts\CartResolver;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct(
        protected CartResolver $cartResolver,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $cart = $this->cartResolver->resolve(request('quest_token'));
        $cart->load('items.productSizes.product');

        return response()->json([CartResource::make($cart)]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request): JsonResponse
    {
        $cart = $this->cartResolver->resolve($request->get('guest_token'));
        $productSize = ProductSize::findOrFail($request->product_size_id);
        $pricePerUnit = $productSize->product->price + $productSize->price_adjustment;

        $cartItem = $cart->items()->firstOrNew(['product_size_id' => $productSize->id]);

        if ($cartItem->exists) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
                'price_per_unit' => $pricePerUnit,
            ]);
        } else {
            $cartItem->fill([
                'product_id' => $productSize->product->id,
                'quantity' => $request->quantity,
                'price_per_unit' => $pricePerUnit,
            ])->save();
        }

        return response()->json([
            'message' => 'Товар добавлен в корзину',
            'data' => CartResource::make($cart->fresh(['items.productSize.product']))
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, CartItem $cartItem): JsonResponse
    {
        $cart = $this->cartResolver->resolve($request->get('guest_token'));

        abort_if($cartItem->cart_id !== $cart->id, 403, 'Доступ запрещен');

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'message' => 'количество обновлено',
            'data' => CartResource::make($cartItem->fresh(['items.productSize.product']))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem): JsonResponse
    {
        $cart = $this->cartResolver->resolve(request('guest_token'));

        abort_if($cartItem->cart_id !== $cart->id, 403, 'доступ запрещен');

        $cartItem->delete();

        return response()->json([
            'message' => 'Товар удален',
            'data' => CartResource::make($cartItem->fresh(['items.productSize.product']))
        ]);
    }

    public function clear(): JsonResponse
    {
        $cart = $this->cartResolver->resolve(request('guest_token'));

        DB::transaction(function () use ($cart) {
            $cart->items()->delete();
        });

        return response()->json([
            'message' => 'Корзина очищена',
            'data' => CartResource::make($cart)
        ]);
    }


}
