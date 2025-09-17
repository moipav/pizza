<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('session_id')->nullable();//корзина для гостей(id сессии или UUID
            $table->string('status')->default('active'); //active, ordered, abandoned, canceled
            $table->timestamps();
        });

        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->integer('product_id');
            $table->integer('product_size_id');
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
        Schema::dropIfExists('cart_item');
    }
};

