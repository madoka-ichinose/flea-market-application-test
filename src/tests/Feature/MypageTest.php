<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * マイページに必要な情報が表示されることをテスト
     *
     * @return void
     */
    public function test_mypage_displays_user_information_and_products()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'test_profile.jpg',
        ]);

        $sellingProduct = Product::factory()->create([
            'user_id' => $user->id,
            'product_name' => '出品商品A',
        ]);

        $anotherUser = User::factory()->create();
        $buyingProduct = Product::factory()->create([
            'user_id' => $anotherUser->id,
            'product_name' => '購入商品B',
        ]);

        DB::table('purchases')->insert([
            'buyer_id' => $user->id,
            'product_id' => $buyingProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->profile_image);
        $response->assertSee($sellingProduct->product_name);

        $response = $this->actingAs($user)->get('/mypage?tab=bought');
        $response->assertStatus(200);
        $response->assertSee($buyingProduct->product_name);
    }
}
