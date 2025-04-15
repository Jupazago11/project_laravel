<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeUserIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agrega la columna 'type_user_id' después de 'updated_at'
            $table->unsignedBigInteger('type_user_id')->nullable()->after('updated_at');
            // Crea la llave foránea referenciando 'id' en la tabla 'type_users'
            $table->foreign('type_user_id')
                  ->references('id')
                  ->on('type_users')
                  ->onDelete('set null');  // Si se elimina el tipo, se pone en null; puedes ajustar según necesites
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Primero, elimina la restricción foránea
            $table->dropForeign(['type_user_id']);
            // Luego, elimina la columna
            $table->dropColumn('type_user_id');
        });
    }
}
