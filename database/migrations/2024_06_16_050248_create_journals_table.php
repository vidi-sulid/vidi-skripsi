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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string("invoice", 25);
            $table->string("type", 2)->nullable();
            $table->string('rekening', 20)->nullable();
            $table->string('description');
            $table->double('debit', 16, 2)->default('0.00');
            $table->double('credit', 16, 2)->default('0.00');
            $table->string('cash')->default("K");
            $table->timestamps();
            $table->string('created_by', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
