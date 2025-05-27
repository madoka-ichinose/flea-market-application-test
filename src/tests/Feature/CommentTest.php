<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_post_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('comment.store', $product->id), [
            'content' => 'これはテストコメントです。',
        ]);

        $response->assertRedirect(route('products.show', $product->id));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'これはテストコメントです。',
        ]);
    }

    /** @test */
    public function guest_user_cannot_post_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('comment.store', $product->id), [
            'content' => '未ログインユーザーのコメント',
        ]);

        $response->assertRedirect(route('login')); 
    }

    /** @test */
    public function comment_is_required()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->from(route('products.show', $product->id))
                         ->post(route('comment.store', $product->id), [
                             'content' => '',
                         ]);

        $response->assertRedirect(route('products.show', $product->id));
        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function comment_must_not_exceed_255_characters()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->from(route('products.show', $product->id))
                         ->post(route('comment.store', $product->id), [
                             'content' => $longComment,
                         ]);

        $response->assertRedirect(route('products.show', $product->id));
        $response->assertSessionHasErrors(['content']);
    }
}
