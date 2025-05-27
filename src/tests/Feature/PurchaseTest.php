<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_purchase_a_product_and_it_is_marked_sold_and_listed_in_profile()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => 'テストビル101',
        ]);
        $product = Product::factory()->create([
            'is_sold' => false,
        ]);

        $response = $this->actingAs($user);

        $response = $this->post(route('purchase.pay'), [
            'product_id' => $product->id,
            'payment_method' => 'convenience',
        ]);

        $response->assertRedirect(route('mypage'));
        $response->assertSessionHas('success', '購入が完了しました');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => true,
        ]);

        $this->assertDatabaseHas('purchases', [
            'buyer_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get(route('products.index'));
        $response->assertSee('Sold');

        $response = $this->get(route('mypage', ['tab' => 'bought']));
        $response->assertSee($product->product_name);
    }
}
