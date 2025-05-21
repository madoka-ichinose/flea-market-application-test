<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_is_required_to_login()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertRedirect(); 
    }

    /** @test */
    public function password_is_required_to_login()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
        $response->assertRedirect(); 
    }

    /** @test */
    public function login_fails_with_incorrect_credentials()
    {
        User::create([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => Hash::make('correctpassword'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors([
            'email' => trans('auth.failed'), 
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/'); 
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_logout()
    {
        // ユーザー作成＆ログイン
        $user = User::factory()->create();

        $this->actingAs($user);

        // ログアウトリクエスト送信（通常はPOST）
        $response = $this->post('/logout');

        // ログアウト後は未認証状態
        $this->assertGuest();

        // ログアウト後のリダイレクト先を確認（通常は /login など）
        $response->assertRedirect('/');
    }
}

