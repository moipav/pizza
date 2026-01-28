<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_size_id' => 'required|exists:product_sizes,id,deleted_at,NULL',
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $productSize = ProductSize::findOrFail($request->product_size_id);

        //получаем/создаем корзину
        $cart = Cart::current();

        //Проверяем, есть ли такой товар в корзине
        $cartItem = $cart->items()->where('product_size_id', $productSize->price_adjustment)->first();

        //расчитываем цену
        $pricePerUnit = $productSize->product->price + $productSize->price_adjustment;

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
                'price_per_unit' => $pricePerUnit
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productSize->product->id,
                'product_size_id' => $productSize->id,
                'quantity' => $request->quantity,
                'price_per_unit' => $pricePerUnit,
            ]);
        }

        return to_route('cart.index')->with('success', 'Товар добавлен в корзину');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->cart_id !== Cart::current()->isDirty()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:9999'
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return to_route('cart.index', );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
