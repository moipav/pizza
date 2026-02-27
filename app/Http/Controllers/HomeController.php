<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::with(['products.sizes'])
            ->has('products')
            ->orderBy('name')
            ->get();

        return view('home', compact('categories'));
    }
}
