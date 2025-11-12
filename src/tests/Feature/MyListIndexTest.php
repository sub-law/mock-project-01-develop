<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class MyListIndexTest extends TestCase
{
    use RefreshDatabase;

    // 設計メモ①：いいねした商品だけが表示される
    public function test_いいねした商品だけが表示される()
    {
        $user = User::create([
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $favoritesProduct = Product::create([
            'seller_id' => $user->id,
            'name' => 'いいね商品',
            'description' => '説明',
            'image_path' => 'like.jpg',
            'category' => 'カテゴリ',
            'condition' => '良好',
            'price' => 1000,
        ]);

        $otherProduct = Product::create([
            'seller_id' => $user->id,
            'name' => '非いいね商品',
            'description' => '説明',
            'image_path' => 'other.jpg',
            'category' => 'カテゴリ',
            'condition' => '良好',
            'price' => 2000,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $favoritesProduct->id,
        ]);

        $user->refresh();
        $user->load('favorites.product');

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいね商品');
        $response->assertDontSee('非いいね商品');

    }


    // 設計メモ②：購入済み商品には「Sold」ラベルが表示される
    public function test_購入済み商品には_Sold_ラベルが表示される()
    {
        $user = User::create([
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $product = Product::create([
            'seller_id' => $user->id,
            'buyer_id' => $user->id, // SOLD判定に必要
            'name' => '購入済み商品',
            'description' => '説明',
            'image_path' => 'sold.jpg',
            'category' => 'カテゴリ',
            'condition' => '良好',
            'price' => 3000,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $user->load('favorites.product');

        $this->actingAs($user);
        
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }


    // 設計メモ③：未認証の場合は何も表示されない
    public function test_未認証の場合は何も表示されない()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('マイリスト機能を利用するにはログインしてください。');
    }
}
