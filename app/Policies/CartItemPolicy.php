<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization;

    /**
     * Проверяет, принадлежит ли элемент корзины текущей активной корзине
     */
    public function modify(?User $user, CartItem $cartItem, Cart $currentCart): bool
    {
        return $cartItem->cart_id === $currentCart->id;
    }
}
