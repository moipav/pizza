<?php

namespace App\Http\Controllers;

use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductSizeController extends Controller
{

    public function index(): View
    {
        return view('products.sizes.index', ['productSizes' => ProductSize::all()]);
    }


    public function create(): View
    {
        return view('products.sizes.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product,id',
            'size_name' => 'required|string|max:50',
            'size_value'=> 'required|numeric',
            'unit'=>'required|string|max:10',
            'price_adjustment' => 'required|numeric|min:0',
        ]);

        ProductSize::create($validated);

        return to_route('product-sizes.index')->with('Новый размер добавлен');
    }


    public function show(string $id): View
    {
        return view('products.sizes.show');
    }


    public function edit(string $id): View
    {
        return view('product.sizes.edit', ['product_size' => ProductSize::findOrFail($id)]);
    }


    public function update(Request $request, ProductSize $size): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product,id',
            'size_name' => 'required|string|max:50',
            'size_value'=> 'required|numeric',
            'unit'=>'required|string|max:10',
            'price_adjustment' => 'required|numeric|min:0',
        ]);

        ProductSize::update($validated);
// можно добавить чтобы название пропечатывалось в сообщении
        return to_route('product-sizes.index')->with('succes', 'Размер обновлен');
    }


    public function destroy(ProductSize $size): RedirectResponse
    {
        $size->delete();

        return to_route('product-sizes.index')->with('success', 'Размер удален');
    }
}
