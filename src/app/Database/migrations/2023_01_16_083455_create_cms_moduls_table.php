<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_moduls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('name');
            $table->string('path');
            $table->string('icon');
            $table->enum('type',['menu','module'])->default('menu');
            $table->string('controller')->nullable();
            $table->json('except_route')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->integer('sorting')->default(1);
            $table->json('actions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_moduls');
    }
};
