<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Contracts\CartResolver;
use App\Models\Cart;
use App\Models\CartStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiCartResolver implements CartResolver
{

    public function resolve(?string $guestToken = null): Cart
    {
        $activeStatus = CartStatus::where('name', 'active')->firstOrFail();
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null, 'status_id' => $activeStatus->id]);
        }

        //гость
        $token = $guestToken ?? Str::uuid()->toString();
        return Cart::firstOrCreate(
            ['session_id' => $token],
            ['user_id' => null, 'status_id' => $activeStatus->id]
        );
    }
}
