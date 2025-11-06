<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = $product->favorites->contains('user_id', Auth::id());
        }

        return view('products.product_show', compact('product', 'isFavorited'));
    }

    public function showpurchaseform($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();

        if ($product->is_sold) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('status', 'この商品はすでに購入されています');
        }

        return view('products.purchase', compact('product', 'user'));
    }
}
