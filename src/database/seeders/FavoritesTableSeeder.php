<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    public function run()
    {
        // ユーザーBが商品ID 2, 3 をお気に入り
        Favorite::create([
            'user_id' => 2,
            'product_id' => 2,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 3,
        ]);

        // ユーザーCが商品ID 1 をお気に入り
        Favorite::create([
            'user_id' => 3,
            'product_id' => 1,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 2,
        ]);
    }
}
