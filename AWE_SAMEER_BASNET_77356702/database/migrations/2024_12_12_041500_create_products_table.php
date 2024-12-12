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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing product ID
            $table->string('product_name'); // Product name
            $table->decimal('product_price', 12, 2); // Product price (up to 2 decimal places)
            $table->unsignedBigInteger('added_by'); // ID of the user who added the product
            $table->timestamp('added_on')->useCurrent(); // Default current timestamp // Date and time when the product was added
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('vat_percent', 5, 2); // VAT percentage (up to 2 decimal places)
            $table->decimal('total_amount_with_vat', 12, 2); // Total amount with VAT included
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
