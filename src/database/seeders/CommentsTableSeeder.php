<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // ユーザーCが商品ID 1 にコメント
        Comment::create([
            'user_id' => 3,
            'product_id' => 1,
            'content' => '素敵な腕時計ですね！',
        ]);

        // ユーザーBが商品ID 5 にコメント
        Comment::create([
            'user_id' => 1,
            'product_id' => 5,
            'content' => 'このノートPC、スペック気になります',
        ]);

        Comment::create([
            'user_id' => 2,
            'product_id' => 5,
            'content' => 'このノートPC、スペック気になります',
        ]);
    }
}
