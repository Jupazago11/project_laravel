<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeUsersTable extends Migration
{
    public function up()
    {
        Schema::create('type_users', function (Blueprint $table) {
            $table->id(); // Campo 'id' (clave primaria)
            $table->string('type'); // Campo 'type' para el nombre o descripción
            $table->integer('status')->default(1); // Campo 'status' numérico (por ejemplo, 1 para activo)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_users');
    }
}
