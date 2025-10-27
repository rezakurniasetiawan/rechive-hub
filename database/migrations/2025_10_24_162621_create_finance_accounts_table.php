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
        Schema::create('finance_accounts', function (Blueprint $table) {
            $table->id();
            // bank_name, bank_number, fullname, type, balance, logo, created_by
            $table->string('bank_name');
            $table->string('bank_number')->nullable();
            $table->string('fullname');
            $table->string('type');
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('logo')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_accounts');
    }
};
