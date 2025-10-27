<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function storecomment(CommentRequest $request)
    {
        Comment::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('message', 'コメントを投稿しました！');
    }
}
