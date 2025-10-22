<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;

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

    public function store(ExhibitionRequest $request)
    {
        $user = auth()->user();

        $product = new Product();
        $product->seller_id = $user->id;
        $product->name = $request->input('name');
        $product->brand = $request->input('brand'); // brandは任意項目なのでバリデーションなしでもOK
        $product->description = $request->input('description');

        // 画像アップロード処理
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('products', 'public');
            $filename = basename($path); // ファイル名だけを取り出す
            $product->image_path = $filename;
        }

        $product->category = implode(',', $request->input('category', []));
        $product->condition = $request->input('condition');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('mypage')->with('status', '商品を出品しました！');
    }
}
