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
        Schema::create('finance_daily_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // 🧑‍💼 siapa yang buat
            $table->date('date')->unique();
            $table->decimal('income_total', 15, 2)->default(0);
            $table->decimal('expense_total', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('finance_weekly_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->year('year');
            $table->unsignedTinyInteger('week');
            $table->decimal('income_total', 15, 2)->default(0);
            $table->decimal('expense_total', 15, 2)->default(0);
            $table->timestamps();
            $table->unique(['year', 'week', 'created_by']); // per user unik
        });

        Schema::create('finance_monthly_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->year('year');
            $table->unsignedTinyInteger('month');
            $table->decimal('income_total', 15, 2)->default(0);
            $table->decimal('expense_total', 15, 2)->default(0);
            $table->timestamps();
            $table->unique(['year', 'month', 'created_by']);
        });

        Schema::create('finance_yearly_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->year('year');
            $table->decimal('income_total', 15, 2)->default(0);
            $table->decimal('expense_total', 15, 2)->default(0);
            $table->timestamps();
            $table->unique(['year', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_daily_balances');
        Schema::dropIfExists('finance_weekly_balances');
        Schema::dropIfExists('finance_monthly_balances');
        Schema::dropIfExists('finance_yearly_balances');
        Schema::dropIfExists('finance_balances_tables');
    }
};
