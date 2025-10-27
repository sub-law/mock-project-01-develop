<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //public function test_example()
    //{
    //    $response = $this->get('/');

    //    $response->assertStatus(200);
    //}

    use RefreshDatabase;

    /** @test */
    public function ログイン機能1()
    {
        $user = User::factory()->create([
            'email' => 'usera@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'usera@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function ログイン機能2()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function ログアウト機能()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'email' => 'usera@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/'); // 遷移先に応じて調整

        $this->assertGuest();
    }
}