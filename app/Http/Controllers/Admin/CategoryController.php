<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
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


    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->all());

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


    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->all());

        return to_route('categories.index')->with('success', 'Название категории изменено!');
    }


    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            return to_route('categories.index')->with('success', 'Категория удалена');
        } catch (\Exception $e) {
            return to_route('categories.index')->with('error', 'Категория не удалена');
        }
    }
}
