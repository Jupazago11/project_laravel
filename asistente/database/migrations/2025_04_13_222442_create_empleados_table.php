<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            // FK hacia la tabla 'users'
            $table->unsignedBigInteger('user_id')->index();
            // FK hacia la tabla 'roles'
            $table->unsignedBigInteger('role_id')->index();
            // Otros campos opcionales de empleado
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
};
