<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\AddItemToCart;
use App\Actions\Cart\UpdateCartItemQuantity;
use App\Contracts\CartResolver;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{

    public function __construct(
        private readonly AddItemToCart         $addItemToCart,
        private readonly UpdateCartItemQuantity $updateCartItemQuantity,
        private readonly CartResolver          $cartResolver,
    )
    {

    }

    public function store(StoreCartItemRequest $request): RedirectResponse
    {
        try {
            $cart = $this->cartResolver->resolve();
            $productSize = ProductSize::with('product')->findOrFail($request->product_size_id);
            $this->addItemToCart->execute(
                $cart,
                $productSize,
                (int)$request->quantity,
            );

            return to_route('home')->with('success', 'Товар добавлен в корзину');
        }catch (\Throwable $exception){
            report($exception);
            return to_route('home')->with('error', 'Не удалось добавить товар');
        }

    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        try {
            $currentCart = $this->cartResolver->resolve();
            if ($cartItem->cart_id !== $currentCart->id) {
                abort(403, 'Доступ запрещен');
            }

            $this->updateCartItemQuantity->execute($cartItem, (int)$request->quantity);

            return to_route('cart.index')
                ->with('success', 'Данные обновлены');
        } catch (\Throwable $exception) {
            report($exception);
            return to_route('cart.index')->with('error', 'Не удалось обновить количество');
        }
    }


    public function destroy(CartItem $cartItem, CartResolver $resolver): RedirectResponse
    {
        try {
            $currentCart = $resolver->resolve();
            if ($cartItem->cart_id !== $currentCart->id) {
                abort(403);
            }

            $cartItem->delete();

            return to_route('cart.index')
                ->with('success', 'Товар удален');
        } catch (\Throwable $exception) {
            report($exception);
            return to_route('cart.index')->with('error', 'Не удалось удалить товар');
        }

    }
}
