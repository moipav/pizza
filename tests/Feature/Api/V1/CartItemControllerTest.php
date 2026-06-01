<?php declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private CartStatus $activeStatus;
    private Category $category;
    private Product $product;
    private ProductSize $productSize;
    private User $user;
    private string $guestToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activeStatus = CartStatus::create(['name' => 'active']);
        $this->category = Category::create(['name' => 'Пицца']);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Пепперони',
            'description' => 'Test description',
            'price' => 100.00,
            'image' => null,
        ]);

        $this->productSize = ProductSize::create([
            'product_id' => $this->product->id,
            'size_name' => 'средняя',
            'size_value' => 42.00,
            'unit' => 'шт',
            'price_adjustment' => 20.00,
        ]);

        $this->user = User::factory()->create();
        $this->guestToken = (string) \Illuminate\Support\Str::uuid();
    }

    private function guestHeaders(): array { return ['X-Guest-Token' => $this->guestToken]; }



    #[Test] public function validation_fails_for_invalid_data(): void
    {
        $this->postJson('/api/v1/cart/items', ['product_size_id' => 99999, 'quantity' => 0])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['product_size_id', 'quantity']);
    }

    #[Test] public function user_can_update_their_cart_item_quantity(): void
    {
        $cart = Cart::create(['user_id' => $this->user->id, 'status_id' => $this->activeStatus->id, 'session_id' => null]);
        $cartItem = CartItem::create([
            'cart_id' => $cart->id, 'product_id' => $this->product->id,
            'product_size_id' => $this->productSize->id, 'quantity' => 1, 'price_per_unit' => 120.00
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/v1/cart/items/{$cartItem->id}", ['quantity' => 5])
            ->assertStatus(200)
            ->assertJsonPath('data.total_quantity', 5);

        $this->assertDatabaseHas('cart_items', ['id' => $cartItem->id, 'quantity' => 5]);
    }

    #[Test] public function cannot_update_other_users_cart_item(): void
    {
        $otherUser = User::factory()->create();
        $otherCart = Cart::create(['user_id' => $otherUser->id, 'status_id' => $this->activeStatus->id, 'session_id' => null]);
        $cartItem = CartItem::create([
            'cart_id' => $otherCart->id, 'product_id' => $this->product->id,
            'product_size_id' => $this->productSize->id, 'quantity' => 1, 'price_per_unit' => 120.00
        ]);

        $this->actingAs($this->user, 'sanctum')
            ->putJson("/api/v1/cart/items/{$cartItem->id}", ['quantity' => 10])
            ->assertStatus(403)
            ->assertJson(['message' => 'Доступ запрещен']);
    }




}
