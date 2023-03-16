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
        Schema::create('cms_import_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('filename');
            $table->foreignUuid('import_by')->constrained('cms_admin')->onDelete('cascade');
            $table->integer('row_count');
            $table->integer('progres');
            $table->dateTime('complete_at');
            $table->longText('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_import_log');
    }
};
