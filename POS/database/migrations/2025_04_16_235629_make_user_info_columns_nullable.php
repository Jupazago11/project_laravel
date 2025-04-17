<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->string('identification', 20)->nullable()->change();
            $table->string('cellphone', 20)->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->string('eps', 50)->nullable()->change();
            $table->string('compensation_box', 50)->nullable()->change();
            $table->string('arl', 50)->nullable()->change();
            $table->string('pension', 50)->nullable()->change();
            $table->decimal('salary', 10, 2)->nullable()->change();
            $table->date('hire_date')->nullable()->change();
            $table->string('contract_type', 30)->nullable()->change();
            $table->integer('contract_duration')->nullable()->change();
            $table->date('contract_date')->nullable()->change();
            $table->text('observation')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->string('identification', 20)->nullable(false)->change();
            $table->string('cellphone', 20)->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            $table->string('eps', 50)->nullable(false)->change();
            $table->string('compensation_box', 50)->nullable(false)->change();
            $table->string('arl', 50)->nullable(false)->change();
            $table->string('pension', 50)->nullable(false)->change();
            $table->decimal('salary', 10, 2)->nullable(false)->change();
            $table->date('hire_date')->nullable(false)->change();
            $table->string('contract_type', 30)->nullable(false)->change();
            $table->integer('contract_duration')->nullable(false)->change();
            $table->date('contract_date')->nullable(false)->change();
            $table->text('observation')->nullable(false)->change();
        });
    }
};
