<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_profile_displays_user_information()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'test_profile.jpg',
            'postal_code' => '123-4567',
            'address' => 'テスト町',
            'building' => 'マンション101',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('test_profile.jpg'); // 画像のパス表示
        $response->assertSee('123-4567');
        $response->assertSee('テスト町');
        $response->assertSee('マンション101');

    }
}
