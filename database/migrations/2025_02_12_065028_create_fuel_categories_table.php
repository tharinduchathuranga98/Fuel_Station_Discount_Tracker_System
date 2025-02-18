<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // Unique category code (e.g., "CAT-001")
            $table->string('name'); // Category name (e.g., "Premium", "Standard")
            $table->string('fuel_type_code'); // Fuel type this category applies to
            $table->decimal('discount_price', 8, 2); // Discount price for this fuel type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_categories');
    }
};
