<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Product;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        // 商品ID 1（腕時計）をユーザーBが購入
        Purchase::create([
            'user_id' => 2, // ユーザーB
            'product_id' => 1, // 腕時計
            'payment_method' => 'credit_card',
        ]);

        // 商品の buyer_id を更新して購入済みにする
        $product = Product::find(1);
        $product->buyer_id = 2;
        $product->status = 'sold';
        $product->save();
    }
}
