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
        Schema::table('finance_daily_balances', function (Blueprint $table) {
            // Hapus unique pada kolom date
            $table->dropUnique(['date']);

            // Tambah unique baru per user
            $table->unique(['date', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_daily_balances', function (Blueprint $table) {
            $table->dropUnique(['date', 'created_by']);
            $table->unique('date');
        });
    }
};
