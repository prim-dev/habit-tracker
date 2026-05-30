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
        Schema::create('habits', function (Blueprint $table) {

            $table->id();

            // Habit Info
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();

            // Streak System
            $table->integer('streak')->default(0);
            $table->integer('longest_streak')->default(0);

            // Completion Tracking
            $table->date('last_completed')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habits');
    }
};