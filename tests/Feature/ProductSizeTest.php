<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductSizeTest extends TestCase
{

    use RefreshDatabase;

    protected Category $category;
    protected Product $product;
    protected ProductSize $productSize;
    protected array $product_size_data;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_product_size_create_page(): void
    {
        $response = $this->get(route('product-sizes.create'));
        $response->assertStatus(200);
        $response->assertViewIs('product-statuses.create');
    }

    public function test_product_size_store(): void
    {


        $response = $this->post('product-sizes', $this->product_size_data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('product-sizes.index'));
        $this->assertDatabaseHas('product_sizes', [
            'size_name' => $this->product_size_data['size_name'],
            'size_value' => $this->product_size_data['size_value']
        ]);

        $this->assertDatabaseCount('product_sizes', 1);
    }

    public function test_product_size_show_page(): void
    {
        $response = $this->get(route('product-sizes.show', $this->productSize));
        $response->assertStatus(200);
        $response->asserViewHas('product-size');
        $response->asserViewHas('product-size', $this->productSize);
        $response->assertSee($this->productSize->size_name);
    }

    public function test_product_size_edit_page(): void
    {
        $response = $this->get(route('product-sizes.edit', $this->productSize));
        $response->assertStatus(200);
        $response->assertViewIs('products.sizes.edit');
//        $response->assertViewHas('products.sizes.edit', $this->productSize);
    }

    public function test_product_size_update(): void
    {
        $updatedData = [
            'product_id' => $this->productSize->id,
            'size_name' => 'Cредняя',
            'size_value' => 30,
            'unit' => 'см',
            'price_adjustment' => 120
        ];
        $this->assertDatabaseHas($this->productSize);
        $response = $this->patch(route('product-sizes.update',  $this->productSize->id), $updatedData);
        $this->assertDatabaseHas('product_sizes', $updatedData);
        $response->assertStatus(302);
    }

    public function test_product_size_destroy(): void
    {
        $this->assertDatabaseCount('product_sizes', 1);

        $response = $this->delete(route('product-sizes.destroy', $this->productSize));
        $response->assertRedirect(route('product-sizes.index'));
        $response->assertSessionHas('success', 'Размер удален');

//        $this->assertSoftDeleted('product_sizes', ['id' => $this->productSize->id]);
    }


    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $image = UploadedFile::fake()->image('pizza.jpg');

        $this->product = Product::create([
            'category_id' => Category::create(['name' => 'pizza'])->id,
            'name' => 'Маргарита',
            'description' => 'Самая популярная пицца в италии',
            'image' => $image,
            'price' => 599
        ]);

        $this->product_size_data = [
            'product_id' => $this->product->id,
            'size_name' => 'Маленькая',
            'size_value' => 25,
            'unit' => 'см',
            'price_adjustment' => 0
        ];

        $this->productSize = ProductSize::create($this->product_size_data);
    }
}
