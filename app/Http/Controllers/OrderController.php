<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrderFromCart;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('orders.index', []);
    }
    public function create(): View
    {
        $cart = Cart::current();

        if ($cart->items->isEmpty()) {
            return to_route('cart.index')
                ->whith('error', 'Корзина пуста');
        }

        return view('orders.create', compact('cart'));
    }

    public function store(Request $request, CreateOrderFromCart $createOrderFromCart): RedirectResponse
    {
        $validated = $request->validate([
            'address' => 'digits:10|nullable|max:255',
            'phone' => 'string|nullable|max:255',
        ]);

        $cart = Cart::current();
//        dd($cart);
            $order = $createOrderFromCart($cart, $validated);
//            dd($order);
            return to_route('orders.index')
                ->with('Заказ оформлен')
                ->setStatusCode(201);
//        } catch (\Exception $exception) {
//            return to_route('cart.index')
//                ->with('error', $exception->getMessage())
//                ->setStatusCode(422);
//        }
    }
}
