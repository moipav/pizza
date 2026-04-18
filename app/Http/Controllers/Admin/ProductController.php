<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::all()
        ]);
    }


    public function create(): View
    {
        return view('products.create', ['categories' => Category::all()]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return to_route('products.index')
            ->with('success', $request->name . ' добавлен')
            ->setStatusCode(302);
    }

    public function show(Product $product): View
    {
        return \view('products.show', ['product' => $product]);
    }


    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }


    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return to_route('products.index', $product)
            ->with('success', 'Данные для ' . $product->name . ' обновлены')
            ->setStatusCode(302);
    }


    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        ProductSize::where('product_id', $product->id)->delete();

        return to_route('products.index')
            ->with('success', 'Продукт удален')
            ->setStatusCode(302);
    }
}
