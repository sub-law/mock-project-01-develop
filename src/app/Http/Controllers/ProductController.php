<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist' && auth()->check()) {
            $products = auth()->user()->favorites->pluck('product');
        } else {
            $products = Product::when(auth()->check(), function ($query) {
                $query->where('seller_id', '!=', auth()->id());
            })->get();
        }

        return view('products.index', compact('products'));
    }

    public function show($item_id)
    {
        $product = Product::with(['favorites', 'comments', 'seller'])->findOrFail($item_id);
        
        return view('products.product_show', compact('product'));
    }
}
