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
        
        $product = Product::factory()->create([
            'product_name' => 'Test Product',
            'brand' => 'Test Brand',
            'price' => 12345,
            'description' => 'This is a test product description.',
            'condition' => '良好',
            'image' => 'test.jpg',
        ]);

        $product->categories()->attach([$category1->id, $category2->id]);

        $user = User::factory()->create(['name' => 'Commenter']);
        Comment::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'content' => 'This is a test comment.',
        ]);

        $product->favorites()->attach($user->id);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('Test Product'); 
        $response->assertSee('Test Brand'); 
        $response->assertSee('¥12,345'); 
        $response->assertSee('This is a test product description.');
        $response->assertSee('ファッション');
        $response->assertSee('家電');
        $response->assertSee('良好'); 
        $response->assertSee('💬1'); 
        $response->assertSee('Commenter'); 
        $response->assertSee('This is a test comment.');
        $response->assertSee('test.jpg'); 
        $response->assertSee('1'); 
    }
}
