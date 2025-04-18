<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                  ->constrained('company')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('category_id')
                  ->constrained('category')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('provider_id')
                  ->constrained('providers')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('product_code', 50)->nullable();
            $table->string('name', 150);
            $table->text('description')->nullable();         // ← ahora nullable

            $table->decimal('cost', 10, 2)->default(0);
            $table->foreignId('iva_rate_id')
                  ->constrained('iva_rates')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->decimal('inc_rate', 5, 2)->default(0);
            $table->decimal('additional_tax', 10, 2)->default(0);

            $table->decimal('price_1', 10, 2)->default(0);
            $table->decimal('price_2', 10, 2)->nullable();   // ← ahora nullable
            $table->decimal('price_3', 10, 2)->nullable();   // ← ahora nullable

            $table->boolean('track_inventory')->default(false);
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

