<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function index(): View
    {
        return view('products.categories.index', ['categories' => Category::all()]);
    }


    public function create(): View
    {
        return view('products.categories.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => '|required|string|max:255|unique'
        ]);

        Category::create($validated);

        return to_route('categories.index')->with('success', 'Категория добавлена');
    }


    public function show(string $id): View
    {
        return view('products.categories.show', ['category' => Category::findOrFail($id)]);
    }


    public function edit(string $id): View
    {
        return view('products.categories.edit', ['category' => Category::findOrFail($id)]);
    }


    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name' . $category->id,
        ]);

        $category->update($validated);

        return to_route('categories.index')->with('success', 'Название категории изменено!');
    }


    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return to_route('categories.index')->with('success', 'Категория удалена');
        } catch (\Exception $e) {
            return to_route('categories.index')->with('error', 'Категория не удалена');
        }
    }
}
