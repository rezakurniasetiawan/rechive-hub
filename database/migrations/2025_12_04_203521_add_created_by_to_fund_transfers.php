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
        // make sure column exists
        if (! Schema::hasColumn('fund_transfers', 'created_by')) {
            Schema::table('fund_transfers', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('date');
            });
        }

        // add FK in try/catch so migration won't crash if FK already exists
        try {
            Schema::table('fund_transfers', function (Blueprint $table) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            });
        } catch (\Throwable $e) {
            // ignore (likely fk already exists)
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('fund_transfers', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
            });
        } catch (\Throwable $e) {
        }
    }
};
