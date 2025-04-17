<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_info_id')->nullable()->after('company_id');
            $table->foreign('user_info_id')
                  ->references('id')->on('user_info')
                  ->onDelete('set null');
        });
        
    }

    public function down()
    {
        // Primero, si existe la columna, eliminamos la FK y la columna
        if (Schema::hasColumn('users', 'user_info_id')) {
            Schema::table('users', function (Blueprint $table) {
                // Solo intentamos soltar la FK si existe
                $sm = Schema::getConnection()
                            ->getDoctrineSchemaManager()
                            ->listTableForeignKeys('users');

                if (collect($sm)->pluck('localColumns')->flatten()->contains('user_info_id')) {
                    $table->dropForeign(['user_info_id']);
                }
                $table->dropColumn('user_info_id');
            });
        }
    }
};
