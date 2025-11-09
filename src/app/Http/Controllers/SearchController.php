<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $tab = $request->input('tab');

        if ($tab === 'mylist' && auth()->check()) {
            $products = auth()->user()->favorites->pluck('product')->filter(function ($product) use ($query) {
                return str_contains($product->name, $query) || str_contains($product->brand, $query);
            });
        } 
        
        else {
            $products = Product::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('brand', 'like', "%{$query}%");
            })
                ->when(auth()->check(), function ($queryBuilder) {
                    $queryBuilder->where('seller_id', '!=', auth()->id());
                })
                ->get();
        }

        return view('products.search', compact('products', 'query'));
    }
}