<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');

            // FK a Company (sin 'after')
            $table->unsignedBigInteger('company_id');

            $table->string('name', 150);
            $table->string('nit', 50)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('contact', 150)->nullable();
            $table->string('employee_name', 100)->nullable();
            $table->string('employee_phone', 20)->nullable();

            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // Definición de la clave foránea
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::dropIfExists('providers');
    }
};
