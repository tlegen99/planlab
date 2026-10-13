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
        Schema::create('task_user', function (Blueprint $table) {
            $table->foreignId('task_id');
            $table->foreignId('user_id');
            $table->smallInteger('role')->default(0);
            $table->timestampsTz();

            // 1 роль = 1 юзер в задаче
            $table->primary(['task_id', 'user_id', 'role']);
            $table->index(['user_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user');
    }
};
