<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
//        return view('home', [
//            'products' => Product::with(['sizes', 'category'])
//                ->select('products.*')
//                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
//                ->orderBy('categories.id')
//                ->orderBy('products.name')
//                ->get(),
//        ]);
        $categories = Category::with(['products.sizes'])
            ->has('products')
            ->orderBy('name')
            ->get();

        return view('home', compact('categories'));
    }
}
