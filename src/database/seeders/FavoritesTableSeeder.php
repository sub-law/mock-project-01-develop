<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    public function run()
    {
        Favorite::create([
            'user_id' => 2,
            'product_id' => 2,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 3,
        ]);

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
