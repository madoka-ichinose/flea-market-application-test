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
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('fa-star'); 

        $response = $this->post("/favorite/{$product->id}");
        $response->assertJson([
            'status' => 'added',
            'count' => 1,
        ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('1'); 
        $response->assertSee('fas fa-star');

        $response = $this->post("/favorite/{$product->id}");
        $response->assertJson([
            'status' => 'removed',
            'count' => 0,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('0');
        $response->assertSee('far fa-star'); 
    }
}

