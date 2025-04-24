<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relación con la empresa
            $table->unsignedBigInteger('company_id');
            // Relación con el cliente
            $table->unsignedBigInteger('client_id');
            // (Opcional) Relación con factura, si existe la tabla invoices
            $table->unsignedBigInteger('invoice_id')->nullable();

            // Monto del abono
            $table->decimal('amount', 10, 2);
            // Indicador de si quedó saldado (limpio)
            $table->boolean('is_cleared')->default(false);
            // Fecha en que se realiza el abono
            $table->date('payment_date');

            $table->timestamps();

            // Índices y claves foráneas
            $table->foreign('company_id')
                  ->references('id')->on('company')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Si ya existe la tabla invoices, descomenta:
            /*
            $table->foreign('invoice_id')
                  ->references('id')->on('invoices')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
