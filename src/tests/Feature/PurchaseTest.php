<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_complete_purchase()
    {
        // ユーザーと商品を作成
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'is_sold' => false,
        ]);

        // 認証ユーザーとして購入完了ルートにアクセス
        $response = $this->actingAs($user)->get(route('purchase.complete', ['product_id' => $product->id]));

        // 購入処理後のリダイレクトとフラッシュメッセージを確認
        $response->assertRedirect(route('mypage'));
        $response->assertSessionHas('success', '購入が完了しました');

        // 商品が売却済みになっていることを確認
        $this->assertTrue($product->fresh()->is_sold);

        // 購入テーブルにレコードが追加されていることを確認
        $this->assertDatabaseHas('purchases', [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
    
    public function test_purchased_product_is_marked_as_sold_on_index_page()
    {
        $user = \App\Models\User::factory()->create();
        $product = \App\Models\Product::factory()->create([
            'product_name' => 'テスト商品',
            'is_sold' => false,
        ]);
    
        // 購入処理（コンビニ支払い）
        $this->actingAs($user)->post('/purchase/pay', [
            'product_id' => $product->id,
            'payment_method' => 'convenience',
        ]);
    
        // 商品一覧ページを確認
        $response = $this->actingAs($user)->get('/');
    
        // 商品名が表示され、"Sold" という表示が含まれていることを確認
        $response->assertSee('テスト商品');
        $response->assertSee('Sold');
    }
    

    public function test_purchased_product_appears_in_user_purchase_list()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'product_name' => 'Test Product',
            'is_sold' => false,
        ]);

        $this->actingAs($user)->post('/purchase/pay', [
            'product_id' => $product->id,
            'payment_method' => 'convenience',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertSee('購入した商品');
        $response->assertSee('Test Product');
    }
}
