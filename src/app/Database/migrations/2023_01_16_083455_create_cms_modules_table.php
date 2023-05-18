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
        Schema::create('cms_modules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->timestamps();
            $table->string('name');
            $table->string('path')->index('cms_module_path');
            $table->string('icon');
            $table->enum('type',['menu','module'])->default('menu');
            $table->string('controller')->nullable();
            $table->json('except_route')->nullable();
            $table->integer('parent_id')->nullable()->index('cms_module_parent_id');
            $table->integer('sorting')->default(1)->index('cms_module_sorting');
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
        Schema::dropIfExists('cms_modules');
    }
};
