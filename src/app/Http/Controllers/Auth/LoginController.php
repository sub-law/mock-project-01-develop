<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/mypage');
        }

        return back()->withErrors([
            'email' => '認証に失敗しました。メールアドレスまたはパスワードをご確認ください。',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('message', 'ログアウトしました');
    }
}
