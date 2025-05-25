<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class FavoriteFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_toggle_favorite_and_count_is_updated()
    {
        // ユーザーと商品を作成
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // ユーザーとしてログイン
        $this->actingAs($user);

        // 商品詳細ページにアクセスして初期状態を確認（お気に入りなし）
        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('fa-star'); // アイコンの存在確認（未いいね）

        // 1回目のいいね（登録）
        $response = $this->post("/favorite/{$product->id}");
        $response->assertJson([
            'status' => 'added',
            'count' => 1,
        ]);

        // データベースに登録されたか確認
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 商品詳細ページに再アクセスして、いいね数とアイコン確認
        $response = $this->get("/item/{$product->id}");
        $response->assertSee('1'); // カウント
        $response->assertSee('fas fa-star'); // 塗りつぶしアイコン

        // 2回目のいいね（解除）
        $response = $this->post("/favorite/{$product->id}");
        $response->assertJson([
            'status' => 'removed',
            'count' => 0,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        // 再びページにアクセスしてアイコンが戻っているか確認
        $response = $this->get("/item/{$product->id}");
        $response->assertSee('0');
        $response->assertSee('far fa-star'); // アウトラインアイコン
    }
}

