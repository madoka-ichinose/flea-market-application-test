<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_update_address_and_it_reflects_on_purchase_page()
    {
        $user = User::factory()->create([
            'postal_code' => '1000001',
            'address' => '東京都千代田区',
            'building' => 'ユーザー初期ビル',
        ]);

        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('purchase.show', $product->id));
        $response->assertStatus(200);
        $response->assertSee('〒 1000001');
        $response->assertSee('東京都千代田区');
        $response->assertSee('ユーザー初期ビル');

        $newAddress = [
            'postal_code' => '1600022',
            'address' => '東京都新宿区新宿',
            'building' => 'テストマンション101号室',
        ];

        $response = $this->post(route('purchase.address.update', $product->id), $newAddress);
        $response->assertRedirect(route('purchase.show', $product->id));

        $response = $this->get(route('purchase.show', $product->id));
        $response->assertStatus(200);
        $response->assertSee('〒 1600022');
        $response->assertSee('東京都新宿区新宿');
        $response->assertSee('テストマンション101号室');
    }
}

