<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductSizeController extends Controller
{

    public function index(): View
    {
        return view('products.sizes.index', [
            'productSizes' => ProductSize::all(),
        ]);
    }


    public function create(): View
    {
        return view('products.sizes.create', [
            'products' => Product::all(),
            'productSizes' => ProductSize::all(),
            'productSizeNames' => ProductSize::distinct()->pluck('size_name'),
            'productSizeValues' => ProductSize::distinct()->pluck('size_value'),
            'productSizeUnits' => ProductSize::distinct()->pluck('unit'),
            'priceAdjustments' => ProductSize::distinct()->pluck('price_adjustment'),
        ]);
    }


    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_name' => 'required|string|max:50',
            'size_value' => [
                'required',
                'numeric',
                Rule::unique('product_sizes')
                    ->where('product_id', $request->input('product_id'))
                    ->where('size_name', $request->input('size_name'))
                    ->where('size_value', $request->input('size_value')),
            ],
            'unit' => 'required|string|max:10',
            'price_adjustment' => 'required|numeric|min:0',
        ]);

        ProductSize::create($validated);

        return to_route('product-sizes.index')->with('success', 'Новый размер добавлен');
    }


    public function show(string $id): View
    {
        return view('products.sizes.show', ['productSize' => ProductSize::with('product')->findOrFail($id)]);
    }


    public function edit(string $id): View
    {
        return view('products.sizes.edit', [
            'products' => Product::all(),
            'productSize' => ProductSize::find($id),
            'productSizeNames' => ProductSize::distinct()->pluck('size_name'),
            'productSizeValues' => ProductSize::distinct()->pluck('size_value'),
            'productSizeUnits' => ProductSize::distinct()->pluck('unit'),
            'priceAdjustments' => ProductSize::distinct()->pluck('price_adjustment'),]);
    }


    public function update(Request $request, ProductSize $productSize): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'size_name' => 'required|string|max:50',
            'size_value' => [
                'required',
                'numeric',
                Rule::unique('product_sizes')
                    ->where('product_id', $request->input('product_id'))
                    ->where('size_name', $request->input('size_name'))
                    ->where('size_value', $request->input('size_value'))
                    ->ignore($productSize->id)
            ],
            'unit' => 'required|string|max:10',
            'price_adjustment' => 'required|numeric|min:0',
        ]);


        $productSize->update($validated);

        return to_route('product-sizes.index')->with('success', 'Размер обновлен');
    }


    public function destroy(ProductSize $size): RedirectResponse
    {
        $size->delete();

        return to_route('product-sizes.index')->with('success', 'Размер удален');
    }
}
