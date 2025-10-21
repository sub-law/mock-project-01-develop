<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;



class ProfileController extends Controller
{
    public function setup()
    {
        return view('auth.profile_setup');
    }

    public function update(ProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // バリデーション済みのデータ取得
        $validated = $request->validated();

        // 画像アップロード処理
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/profile_images');
            $user->profile_image = basename($path);
        }
        // else句は不要：前の画像をそのまま使う


        // ユーザー情報更新
        $user->name = $validated['name'];
        $user->postal_code = $validated['postal_code'];
        $user->address = $validated['address'];
        $user->save();

        return redirect()->route('index')->with('status', 'プロフィールを更新しました！');
    }
}
