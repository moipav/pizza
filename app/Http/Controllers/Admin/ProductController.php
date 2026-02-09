<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/*
 * TODO
 * 0. корзина/заказы +/-
 * 1. tests
 * 2. выводим админские контроллеры в отдельную директорию +
 * 3. docker
 *  . debug  разобраться
 * *4. статусы пользователя переделать в role
 *
 */
class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create', ['categories' => Category::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'numeric|min:0'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return to_route('products.index')->with('success', $request->name . ' добавлен');
    }

    public function show(string $id): View
    {
        return \view('products.show', ['product' => Product::findOrFail($id)]);
    }


    public function edit(string $id): View
    {
        return view('products.edit', [
            'product' => Product::findOrFail($id),
            'categories' => Category::all()
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|numeric|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'numeric|min:0'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return back()->with('success', 'Данные для ' . $product->name . ' обновлены');
    }


    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('products.index');
    }
}
