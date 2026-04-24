<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Contracts\CartResolver;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiCartResolver implements CartResolver
{

    public function resolve(): Cart
    {
        if (!Auth::check()) {
            throw new UnauthorizedHttpException('Требуется авторизация');
            // В API работаем только с авторизованными пользователями
            // Или можно добавить логику по заголовку X-Guest-Token, если нужно
        }

        return Cart::firstOrCerate(
            ['user_id' => Auth::id()],
            ['session_id' => null]
        );
    }
}
