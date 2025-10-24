<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

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

    public function storeComment(CommentRequest $request)
    {
        Comment::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::id(),
            'content' => $request->input('content'), 
        ]);

        return redirect()->back()->with('message', 'コメントを投稿しました！');
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

    public function showPurchaseForm($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();

        if ($product->is_sold) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('message', 'この商品はすでに購入されています');
        }

        return view('products.purchase', compact('product', 'user'));
    }
}
