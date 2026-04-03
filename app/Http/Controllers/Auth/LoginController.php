<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    private $guestID;
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $this->mergeCartWithLogin($request->cookie('guestID'));
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
            #переадресация либо на запрашиваемую страницу, либо на /home
        }

        return back()
            ->setStatusCode(401)
            ->withErrors([
                'email' => 'Неверные данные для входа'
            ])->onlyInput('email');

    }

    private function mergeCartWithLogin($guestID)
    {

        /**
         * TODO
         * Надо порефакторить!
         * Вынесем либо в модель полностью либо в Action
         */
        $userId = Auth::id();
        $activeStatus = CartStatus::where('name', 'active')->first();
        $guestCart = Cart::where('session_id', $guestID)->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(
            ['user_id' => $userId, 'status_id' => $activeStatus->id],
        );

        foreach ($guestCart->items as $item) {
            $existingCartItem = $userCart->items()->where('product_size_id', $item->product_size_id)->first();
            if ($existingCartItem) {
                $existingCartItem->update([
                    'quantity' => $existingCartItem->quantity + $item->quantity
                ]);
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->delete();

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }
}
