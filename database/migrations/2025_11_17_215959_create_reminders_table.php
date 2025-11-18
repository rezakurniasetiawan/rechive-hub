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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->dateTime('target_date');
            $table->string('category', 50)->default('custom');
            $table->enum('repeat_type', ['none', 'daily', 'weekly', 'monthly', 'yearly'])->default('none');
            $table->integer('notify_before_hours')->default(0);
            $table->enum('status', ['active', 'completed', 'deleted'])->default('active');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
