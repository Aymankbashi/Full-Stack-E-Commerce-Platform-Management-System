<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // عرض جميع المنتجات
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $products = Product::where('name', 'like', '%' . $query . '%')
                            ->orWhere('category', 'like', '%' . $query . '%')
                            ->orWhere('description', 'like', '%' . $query . '%')
                            ->latest()
                            ->get();
        } else {
            $products = Product::latest()->get();
        }

        return view('products.index', compact('products'));
    }

    // عرض منتج مفصل
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
