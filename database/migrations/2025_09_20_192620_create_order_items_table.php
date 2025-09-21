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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Product Information (snapshot at time of order)
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('product_image')->nullable();
            
            // Order Item Details
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // Price used for this order (could be sale_price or regular price)
            $table->decimal('total_price', 10, 2); // quantity * unit_price
            
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
