<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->id();
            $table->string('identification', 20)->nullable();
            $table->string('cellphone', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('eps', 50)->nullable();
            $table->string('compensation_box', 50)->nullable();
            $table->string('arl', 50)->nullable();
            $table->string('pension', 50)->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->string('contract_type', 30)->nullable();
            $table->integer('contract_duration')->nullable();
            $table->date('contract_date')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_info');
    }
};
