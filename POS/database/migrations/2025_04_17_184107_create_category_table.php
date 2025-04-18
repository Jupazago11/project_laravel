<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('name', 100)->nullable(false);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // FK hacia company.id
            $table->foreign('company_id')
                  ->references('id')->on('company')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
};
