<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\ProductSizeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create();
    }
}
