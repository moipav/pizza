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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // для гостей null
            $table->string('session_id')->nullable(); //если гость
            $table->string('status'); // pending, confirmed, delivered, canceled
            $table->decimal('total', 10, 2);
            $table->string('delivery_address')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Копируем данные на момент покупки!
            $table->string('product_name');      // "Маргарита"
            $table->string('product_size_name'); // "Большая"
            $table->decimal('price', 8, 2);      // 599.00 — цена на момент заказа!
            $table->integer('quantity');         // 2

            // Можно оставить ссылки на оригинальные сущности (для аналитики),
            // но они НЕ должны использоваться для отображения заказа!
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('product_size_id')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
