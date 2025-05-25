<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_displays_required_information()
    {
        $category1 = Category::factory()->create(['category_name' => 'ファッション']);
        $category2 = Category::factory()->create(['category_name' => '家電']);
        // 商品を登録
        $product = Product::factory()->create([
            'product_name' => 'Test Product',
            'brand' => 'Test Brand',
            'price' => 12345,
            'description' => 'This is a test product description.',
            'condition' => '良好',
            'image' => 'test.jpg',
        ]);

        $product->categories()->attach([$category1->id, $category2->id]);

        // ユーザーとコメントを作成
        $user = User::factory()->create(['name' => 'Commenter']);
        Comment::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'content' => 'This is a test comment.',
        ]);

        // お気に入りの数を1つにしておく
        $product->favorites()->attach($user->id);

        // 商品詳細ページにアクセス
        $response = $this->get("/item/{$product->id}");

        // 表示確認
        $response->assertStatus(200);
        $response->assertSee('Test Product'); // 商品名
        $response->assertSee('Test Brand'); // ブランド
        $response->assertSee('¥12,345'); // 価格
        $response->assertSee('This is a test product description.'); // 説明
        $response->assertSee('ファッション');
        $response->assertSee('家電');
        $response->assertSee('良好'); // 商品の状態
        $response->assertSee('💬1'); // コメント数
        $response->assertSee('Commenter'); // コメントユーザー名
        $response->assertSee('This is a test comment.'); // コメント内容
        $response->assertSee('test.jpg'); // 画像パス
        $response->assertSee('1'); // いいね数（数値だけなので注意）

        // 必要ならHTMLタグや特定構造もチェックできるが、より詳細なDOM検証には Laravel Dusk が便利です
    }
}
