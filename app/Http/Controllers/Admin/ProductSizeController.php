<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductSizeRequest;
use App\Http\Requests\Admin\UpdateProductSizeRequest;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
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


    public function store(StoreProductSizeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        ProductSize::create($validated);

        return to_route('product-sizes.index')
            ->with('success', 'Новый размер добавлен')
            ->setStatusCode(302);
    }


    public function show(ProductSize $productSize): View
    {
        return view('products.sizes.show', ['productSize' =>$productSize]);
    }


    public function edit(ProductSize $productSize): View
    {
        return view('products.sizes.edit', [
            'products' => $productSize->product(),
            'productSize' => $productSize,
            'productSizeNames' => ProductSize::distinct()->pluck('size_name'),
            'productSizeValues' => ProductSize::distinct()->pluck('size_value'),
            'productSizeUnits' => ProductSize::distinct()->pluck('unit'),
            'priceAdjustments' => ProductSize::distinct()->pluck('price_adjustment'),]);
    }


    public function update(UpdateProductSizeRequest $request, ProductSize $productSize): RedirectResponse
    {
        $validated = $request->validated();

        $productSize->update($validated);

        return to_route('product-sizes.index')
            ->with('success', 'Размер обновлен')
            ->setStatusCode(302);
    }


    public function destroy(ProductSize $size): RedirectResponse
    {
        $size->delete();

        return to_route('product-sizes.index')
            ->with('success', 'Размер удален')
            ->setStatusCode(302);
    }
}
