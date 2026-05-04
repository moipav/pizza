<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Order\CreateOrderFromCart;
use App\Contracts\CartResolver;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly CartResolver $cartResolver
    )
    {
    }

    public function index(): View
    {
        return view('orders.index', []);
    }

    public function create(): View | RedirectResponse
    {
        $cart = $this->cartResolver->resolve();

        if ($cart->items->isEmpty()) {
            return to_route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        return view('orders.create', compact('cart'));
    }

    public function store(Request $request, CreateOrderFromCart $createOrderFromCart): RedirectResponse
    {
        $validated = $request->validate([
            'address' => 'digits:10|nullable|max:255',
            'phone' => 'string|nullable|max:255',
        ]);

        $cart = $this->cartResolver->resolve();

        try {
            $order = $createOrderFromCart($cart, $validated);
            return redirect()->route('orders.show', ['order' => $order])
                ->with('success', 'Заказ оформлен');

        } catch (\Exception $exception) {
            return to_route('cart.index')
                ->with('error', $exception->getMessage())
                ->setStatusCode(422);
        }
    }

    public function show(Order $order): View
    {
        return view('orders.show', compact('order'));
    }
}
