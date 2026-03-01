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


    private $image;
    private $category;
    private $product;

    public function test_product_index(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_product_create_page(): void
    {
        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');//проверяем шаблон
    }


    /**
     * @throws \JsonException
     */
    public function test_product_store(): void
    {
        $product_store = [
            'category_id' => 1,
            'name' => 'Тест',
            'description' => 'описание',
            'image' => $this->image,
            'price' => '999'
        ];
        $response = $this->post(route('products.store', $product_store));
//        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => $this->product->name,
            'description' => $this->product->description,
            'price' => $this->product->price

        ]);
        $this->assertDatabaseCount('products', 1);
    }

    public function test_product_show_page(): void
    {
        $response = $this->get(route('products.show', $this->product));
        $response->assertStatus(200);
        $response->assertViewHas('product');
        $response->assertViewHas('product', $this->product);
        $response->assertSee($this->product->name);

    }

    public function test_product_edit_page(): void
    {
        $response = $this->get(route('products.edit', $this->product));
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $this->product);

    }

    public function test_product_update(): void
    {
        $updatedData = [
            'category_id' => $this->product->category->id,
            'name' => 'Пепперони',
            'description' => 'Еще одна популярная пицца в италии',
            'price' => 699
        ];

        $response = $this->patch(route('products.update', $this->product), $updatedData);
        $response->assertStatus(302);
        $response->assertRedirect(route('products.index', $this->product));
        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_product_destroy(): void
    {
        $category = Category::create(['id' => '1', 'name' => 'Пицца']);
        Product::factory()->for($category)->create();
        $product = Product::first();

        $this->assertDatabaseCount('products', 2);

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'Продукт удален');
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        //Здесь у нас получается проверить, только на то,что пометили SoftDelete а count у БД все равно 2
        $this->assertDatabaseCount('products', 2);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->image = UploadedFile::fake()->image('pizza.jpg');
//        $this->category = Category::create(['id' => '1', 'name' => 'Пицца']);
        $this->product = Product::create([
            'category_id' => Category::create(['id' => '1', 'name' => 'Пицца'])->id,
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'image' => $this->image,
            'price' => 599
        ]);
    }
}
