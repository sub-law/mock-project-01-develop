<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    // 設計メモ①：名前が未入力の場合、バリデーションメッセージが表示される
    public function test_名前が未入力の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    // 設計メモ②：メールアドレスが未入力の場合、バリデーションメッセージが表示される
    public function test_メールアドレスが未入力の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    // 設計メモ③：パスワードが未入力の場合、バリデーションメッセージが表示される
    public function test_パスワードが未入力の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    // 設計メモ④：パスワードが7文字以下の場合、バリデーションメッセージが表示される
    public function test_パスワードが7文字以下の場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    // 設計メモ⑤：パスワード確認と一致しない場合、バリデーションメッセージが表示される
    public function test_パスワード確認と一致しない場合_バリデーションメッセージが表示される()
    {
        $response = $this->post('/register', [
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }

    // 設計メモ⑥：全項目が正しく入力された場合、プロフィール設定画面に遷移する
    public function test_全項目が正しく入力された場合_プロフィール設定画面に遷移する()
    {
        $response = $this->post('/register', [
            'name' => '太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/email/verify'); 
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
