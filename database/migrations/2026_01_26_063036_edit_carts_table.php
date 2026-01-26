<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('status')->change()->default(1);
            $table->renameColumn('status', 'status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('cart_statuses')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->renameColumn('status_id', 'status');
            $table->string('status')->change()->default('active');
        });
    }
};
