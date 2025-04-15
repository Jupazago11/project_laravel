<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agrega la columna 'status' tipo string, que puede ser nula, justo después de 'remember_token'
            $table->string('status')->nullable()->after('remember_token');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Elimina la columna 'status' al revertir la migración
            $table->dropColumn('status');
        });
    }
}
