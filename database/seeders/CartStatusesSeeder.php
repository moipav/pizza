<?php

namespace Database\Seeders;

use App\Models\CartStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CartStatus::insert([
            ['id' => 1, 'name' => 'active'],
            ['id' => 2, 'name' => 'ordered'],
            ['id' => 3, 'name' => 'abandoned'],
            ['id' => 4, 'name' => 'cancelled'],
        ]);
    }
}
