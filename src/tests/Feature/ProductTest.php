<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function top_page_displays_all_products_except_own_products()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $myProduct = Product::factory()->create([
            'user_id' => $user->id,
        ]);

        $product1 = Product::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $product2 = Product::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertDontSee($myProduct->name);
    }

    /** @test */
    public function sold_products_are_displayed_as_sold()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        Purchase::factory()->create([
            'product_id' => $product->id,
            'buyer_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold'); 
    }

    /** @test */
    public function top_page_displays_all_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertEquals(5, Product::count());

        foreach (Product::all() as $product) {
            $response->assertSee($product->name);
        }
    }
}
