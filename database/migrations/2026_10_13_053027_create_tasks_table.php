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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable();
            $table->foreignId('author_id')->index();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(0);
            $table->smallInteger('visibility')->default(0);
            $table->smallInteger('priority')->default(0);
            $table->dateTimeTz('starts_at')->nullable();
            $table->dateTimeTz('ends_at')->nullable();
            $table->dateTimeTz('completed_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index(['project_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
