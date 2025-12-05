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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('total_budget', 15, 2);
            $table->decimal('total_used', 15, 2)->default(0);
            $table->decimal('total_remaining', 15, 2)->default(0);
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->boolean('is_locked')->default(false);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
