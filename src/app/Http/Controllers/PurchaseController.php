<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function showpurchaseform($item_id)
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
