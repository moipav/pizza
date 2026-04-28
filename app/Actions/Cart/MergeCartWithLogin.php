<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartStatus;
use Illuminate\Support\Facades\DB;
use Throwable;

class MergeCartWithLogin
{
    /**
     * Объединяет гостевую корзину с корзиной пользователя.
     *
     * @param int $userId ID авторизованного пользователя
     * @param string|null $guestIdentifier session_id или guest_token
     * @throws Throwable
     */
    public function execute(int $userId, ?string $guestIdentifier): void
    {
        if (!$guestIdentifier) {
            return;
        }

        DB::transaction(function () use ($userId, $guestIdentifier) {
            //ищем гостевую корзину
            $guestCart = Cart::where('session_id', $guestIdentifier)
                ->whereNull('user_id')
                ->with('items')
                ->first();

            if (!$guestCart) {
                return;
            }

            //получаем или создаем корзину пользователя
            $activeStatus = CartStatus::where('name', 'active')->first();

            $userCart = Cart::firstOrCreate(
                [
                    'user_id' => $userId,
                    'status_id' => $activeStatus->id,
                    'session_id' => null
                ]
            );

            //объединяем позиции
            foreach ($guestCart->items as $guestItem) {
                $existingItem = $userCart->items()
                    ->where('product_size_id', $guestItem->product_size_id)
                    ->first();
                if ($existingItem) {
                    $existingItem->update(['quantity' => $existingItem->quantity + $guestItem->quantity]);
                } else {
                    $guestItem->update(['cart_id' => $userCart->id]);
                }
            }

            $guestCart->delete();

        });
    }
}
