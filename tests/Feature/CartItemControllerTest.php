<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Contracts\CartResolver;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class CartItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private $image;
    private Category $category;
    private Product $product;
    private ProductSize $productSize;
    private CartStatus $activeStatus;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->image = UploadedFile::fake()->image('pizza.jpg');
        $this->category = Category::create(['id' => '1', 'name' => 'Пицца']);
        $this->activeStatus = CartStatus::create(['name' => 'active']);
        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'image' => $this->image,
            'price' => 599
        ]);
        $this->productSize = ProductSize::create([
            'product_id' => $this->product->id,
            'size_name' => 'средняя',
            'size_value' => 30,
            'unit' => 'cm',
            'price_adjustment' => 60,
        ]);

    $user = User::factory()->create();

    }

    public function test_cart_item_store()
    {
        $response = $this->post(route('cart.items.store'), [
            'product_size_id' => $this->productSize->id,
            'quantity' => 1
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('cart_items', [
            'product_size_id' => $this->productSize->id,
            'quantity' => 1
        ]);
    }

    public function test_cart_item_update()
    {
//        $sessionId = session()->getId();
        $test_user = User::factory()->create();
        $cart = Cart::create([
            'user_id' => $test_user->id,
            'session_id' => null,
            'status_id' => $this->activeStatus->id,
        ]);

        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'product_size_id' => $this->productSize->id,
            'quantity' => 1,
            'price_per_unit' => $this->product->price + $this->productSize->price_adjustment,
        ]);

        $mock = Mockery::mock(CartItem::class);
        $mock->shouldReceive('resolve')->andReturn($cart);
        $this->instance(CartResolver::class, $mock);

        $response = $this->put(route('cart.items.update', $cartItem), [
            'quantity' => 3
        ]);
//        $response->assertStatus(302);
//        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'product_size_id' => $this->productSize->id,
            'quantity' => 3
        ]);
    }

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


}
/*
 Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
Route::put('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');
*/
