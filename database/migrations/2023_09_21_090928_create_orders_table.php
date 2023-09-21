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
            $table->string("order_No");
            $table->string("total_price");
            $table->string("order_type");
            $table->unsignedBigInteger("product_id");
            $table->timestamps();

            // Create a foreign key constraint
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['product_id']);
            
            // Drop the table
            $table->dropIfExists('orders');
        });
    }
};
