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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->index();
            $table->foreignId('lead_id')->nullable()->index();
            $table->string('code', 10)->unique()->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
