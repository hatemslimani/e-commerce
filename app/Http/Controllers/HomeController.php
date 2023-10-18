<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
