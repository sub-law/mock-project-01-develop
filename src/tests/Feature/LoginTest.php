<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // 設計メモ①：メールアドレスが未入力の場合、バリデーションメッセージが表示される
    public function test_メールアドレスが未入力の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
        $this->assertGuest();
    }

    // 設計メモ②：パスワードが未入力の場合、バリデーションメッセージが表示される
    public function test_パスワードが未入力の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
        $this->assertGuest();
    }

    // 設計メモ③：未登録の情報を入力した場合、バリデーションメッセージが表示される
    public function test_未登録の情報を入力した場合_ログインエラーが表示される()
    {
        $response = $this->post('/login', [
            'email' => 'notfound@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'auth' => 'ログイン情報が登録されていません',
        ]);
        $this->assertGuest();
    }

    // 設計メモ④：正しい情報を入力した場合、ログイン処理が実行される
    public function test_正しい情報を入力した場合_ログイン処理が実行される()
    {
        $user = User::factory()->create([
            'email' => 'usera@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'usera@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/'); 
        $this->assertAuthenticatedAs($user);
    }

    // 補足：ログアウト機能の確認
    public function test_ログアウト処理が実行される()
    {
        /** @var \App\Models\User $user */

        $user = User::factory()->create([
            'email' => 'usera@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/'); 

        $this->assertGuest();
    }
}
