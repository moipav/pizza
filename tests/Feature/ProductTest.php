<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;


    public function test_product_index(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_product_create_page(): void
    {
        $response = $this->get('/products/create');

        $response->assertStatus(200);
        $response->assertViewIs('products.create');//проверяем шаблон
    }


    /**
     * @throws \JsonException
     */
    public function test_product_store(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('pizza.jpg');
        $category = Category::create(['id' => '1', 'name' => 'Пицца']);
        $product = [
            'category_id' => $category->id,
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'image' => $image,
            'price' => 599
        ];

        $response = $this->post('/products', $product);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'price' => 599

        ]);
        $this->assertDatabaseCount('products', 1);
    }

    public function test_product_show(): void
    {
        Storage::fake('public');
        $category = Category::create(['id' => '1', 'name' => 'Пицца']);

        $product = Product::factory()->create(['category_id' => $category->id])::first();

        $response = $this->get('/products/' . $product->id);
        $response->assertStatus(200);
        $response->assertViewHas('product');
        $response->assertViewHas('product', $product);
        $response->assertSee($product->name);

    }

    public function test_product_edit_page(): void
    {
        Storage::fake('public');
//        $image = UploadedFile::fake()->image('pizza.jpg');
        $category= Category::create(['id' => '1', 'name' => 'Пицца']);
        $product = Product::factory()->create(['category_id' => $category->id]);
        $response = $this->get('/products/' . $product->id . '/edit');
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $product);

    }

    public function test_product_update(): void
    {
        Storage::fake('public');
        $category = Category::create(['id' => '1', 'name' => 'Пицца']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $updatedData = [
            'category_id' => $category->id,
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'price' => 599
        ];

        $response = $this->patch('/products/' . $product->id, $updatedData);
        $response->assertStatus(302);
        $response->assertRedirect('/products/' . $product->id . '/edit');
        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_product_destroy(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('pizza.jpg');

        $category = Category::create(['id' => '1', 'name' => 'Пицца']);
        Product::factory(2)->create([
            'category_id' => $category->id,
            'image' => $image]);

        $product = Product::first();

        $this->assertDatabaseCount('products', 2);

        $response = $this->delete('/products/' . $product->id);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Продукт удален');
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        //Здесь у нас получается проверить, только на то,что пометили SoftDelete а count у БД все равно 2
        $this->assertDatabaseCount('products', 2);
    }

}
