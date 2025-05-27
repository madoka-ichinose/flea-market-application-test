<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品出品ページへのアクセスと登録処理のテスト
     */
    public function test_user_can_access_sell_page_and_register_product()
{
    Storage::fake('public');

    $user = User::factory()->create();

    $category = Category::factory()->create();

    $response = $this->actingAs($user)->get('/sell');
    $response->assertStatus(200);

    $imagePath = base_path('tests/Fixtures/sample.jpg');
    $file = new UploadedFile($imagePath, 'sample.jpg', 'image/jpeg', null, true);

    $postData = [
        'product_name' => 'テスト商品',
        'condition' => '良好',
        'description' => 'テスト用の説明です',
        'price' => 5000,
        'image' => $file,
        'categories' => '1',
    ];

    $response = $this->post('/sell', $postData);

    $response->assertRedirect('/mypage'); 
    $this->assertDatabaseHas('products', [
        'product_name' => 'テスト商品',
    ]);

    $product = Product::where('product_name', 'テスト商品')->first();
    $this->assertDatabaseHas('category_product', [
        'product_id' => $product->id,
        'category_id' => $category->id,
    ]);
}
}
