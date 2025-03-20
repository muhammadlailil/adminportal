<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cms_admins', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',150);
            $table->string('email')->unique();
            $table->foreignId('role_permission_id')->constrained('cms_role_permissions')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->smallInteger('status')->default(1);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_admins');
    }
};
