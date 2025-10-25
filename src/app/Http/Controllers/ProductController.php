<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Comment;
use App\Models\Purchase;

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

    public function storecomment(CommentRequest $request)
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
        $product->brand = $request->input('brand'); 
        $product->description = $request->input('description');

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('products', 'public');
            $filename = basename($path); 
            $product->image_path = $filename;
        }

        $product->category = implode(',', $request->input('category', []));
        $product->condition = $request->input('condition');
        $product->price = $request->input('price');
        $product->status = 'available';
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

    public function purchaseconfirm(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();

        $product = Product::findOrFail($item_id);

        if ($product->buyer_id !== null) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('error', 'この商品はすでに購入されています');
        }


        if (empty($user->postal_code) || empty($user->address)) {
            return redirect()->route('address_edit', ['item_id' => $item_id])
                ->with('error', '配送先住所が未登録です。先に登録してください。');
        }

        Purchase::create([
            'user_id' => $user->id,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building_name' => $user->building_name,
            'product_id' => $product->id,
            'payment_method' => $request->input('payment_method'),
        ]);

        $product->buyer_id = $user->id;
        $product->status = 'sold';
        $product->save();

        return redirect()->route('index')->with('message', '購入が完了しました！');
    }
}
