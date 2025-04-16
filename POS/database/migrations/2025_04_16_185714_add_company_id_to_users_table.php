<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // agrega company_id tras type_user_id, permite nulo y borra en cascada a null
            $table->unsignedBigInteger('company_id')
                  ->nullable()
                  ->after('type_user_id');

            $table->foreign('company_id')
                  ->references('id')->on('company')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};
