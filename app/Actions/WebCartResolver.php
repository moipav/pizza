<?php declare(strict_types=1);

namespace App\Actions;

use App\Contracts\CartResolver;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class WebCartResolver implements CartResolver
{

    public function resolve(): Cart
    {
        if (auth()->check()) {
            //авторизованный пользователь - ищем по user_id
            return Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => null]
            );
        }
        //гость - используем session_id
        $sessionId = Session::getId();
        cookie()->queue('guestID', $sessionId, 60 * 24);
        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }
}
