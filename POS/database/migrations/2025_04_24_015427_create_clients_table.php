<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relación con company
            $table->unsignedBigInteger('company_id');

            $table->string('name');
            $table->string('identification')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Nuevos campos para control de cupo
            $table->decimal('credit_limit', 10, 2)->default(0);      // Límite máximo de crédito
            $table->decimal('current_balance', 10, 2)->default(0);   // Saldo actual pendiente

            $table->tinyInteger('status')->default(1); // 1 = activo, 0 = inactivo
            $table->timestamps();

            // FK -> company(id)
            $table->foreign('company_id')
                  ->references('id')->on('company')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
