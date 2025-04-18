<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iva_rates', function (Blueprint $table) {
            $table->id();                                // PK
            $table->string('code', 20)->unique();        // p.ej. "IVA19", "IVA5"
            $table->string('name', 100);                 // Nombre legible: "Tarifa general 19%"
            $table->decimal('rate', 5, 2);               // Porcentaje: 19.00, 5.00, 0.00
            $table->text('description')->nullable();     // Detalles adicionales (opcional)
            $table->boolean('status')->default(1);       // 1 = activa, 0 = inactiva
            $table->timestamps();                        // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iva_rates');
    }
};
