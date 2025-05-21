<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
public function only_favorited_products_are_displayed_in_mylist()
    {
    $user = User::factory()->create();

    $productA = Product::factory()->create(); // いいねする商品
    $productB = Product::factory()->create(); // いいねしない商品

    // いいねを付与（productA のみ）
    $user->favorites()->attach($productA->id);

    $response = $this->actingAs($user)->get('/?tab=favorites');

    $response->assertStatus(200);

    // いいねした商品は表示される
    $response->assertSee($productA->product_name);

    // いいねしてない商品は表示されない
    $response->assertDontSee($productB->product_name);
    }


    /** @test */
    public function sold_products_are_displayed_with_sold_tag_in_mylist()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $soldProduct = Product::factory()->create([
            'user_id' => $otherUser->id,
            'is_sold' => true,
        ]);

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $soldProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=favorites');

        $response->assertStatus(200);
        $response->assertSee('Sold');
        $response->assertSee($soldProduct->product_name);
    }

    /** @test */
    public function products_user_has_listed_are_not_in_their_mylist()
    {
    $user = User::factory()->create();

    $myProduct = Product::factory()->create(['user_id' => $user->id]); // 自分の商品
    $otherProduct = Product::factory()->create(); // 他人の商品

    // 他人の商品にだけいいね
    $user->favorites()->attach($otherProduct->id);

    $response = $this->actingAs($user)->get('/?tab=favorites');

    $response->assertStatus(200);

    // 他人の商品は表示される
    $response->assertSee($otherProduct->product_name);

    // 自分の商品は表示されない
    $response->assertDontSee($myProduct->product_name);
    }


    /** @test */
public function guest_can_access_mylist_but_sees_no_products()
{
    $response = $this->get('/?tab=favorites');
    $response->assertStatus(200);
    $response->assertDontSee('product-name');
}
}
