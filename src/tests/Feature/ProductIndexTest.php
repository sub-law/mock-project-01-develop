<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_全商品を取得できる()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        Product::create([
            'seller_id' => $seller->id,
            'name' => '商品A',
            'brand' => 'ブランドA',
            'status' => '新品',
            'description' => '説明A',
            'image_path' => 'images/a.jpg',
            'category' => 'カテゴリA',
            'condition' => '良好',
            'price' => 1000,
        ]);

        Product::create([
            'seller_id' => $seller->id,
            'name' => '商品B',
            'brand' => 'ブランドB',
            'status' => '中古',
            'description' => '説明B',
            'image_path' => 'images/b.jpg',
            'category' => 'カテゴリB',
            'condition' => 'やや傷あり',
            'price' => 2000,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('商品A');
        $response->assertSeeText('商品B');
    }

    public function test_購入済み商品には_Sold_ラベルが表示される()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => bcrypt('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password123'),
        ]);

        Product::create([
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
            'name' => '購入済み商品',
            'brand' => 'ブランドC',
            'status' => '中古',
            'description' => '説明C',
            'image_path' => 'images/c.jpg',
            'category' => 'カテゴリC',
            'condition' => '傷あり',
            'price' => 3000,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_自分が出品した商品は一覧に表示されない()
    {
        $user = User::create([
            'name' => '自分',
            'email' => 'self@example.com',
            'password' => bcrypt('password123'),
        ]);

        $otherUser = User::create([
            'name' => '他人',
            'email' => 'other@example.com',
            'password' => bcrypt('password123'),
        ]);

        Product::create([
            'seller_id' => $user->id,
            'name' => '自分の商品',
            'brand' => 'ブランドD',
            'status' => '新品',
            'description' => '説明D',
            'image_path' => 'images/d.jpg',
            'category' => 'カテゴリD',
            'condition' => '未使用',
            'price' => 4000,
        ]);

        Product::create([
            'seller_id' => $otherUser->id,
            'name' => '他人の商品',
            'brand' => 'ブランドE',
            'status' => '中古',
            'description' => '説明E',
            'image_path' => 'images/e.jpg',
            'category' => 'カテゴリE',
            'condition' => '良好',
            'price' => 5000,
        ]);

        $this->actingAs($user);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}
