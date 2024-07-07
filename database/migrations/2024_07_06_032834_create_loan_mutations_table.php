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
        Schema::create('loan_mutations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string("invoice", 25);
            $table->string('rekening');
            $table->string('status')->default(1);
            //$table->foreign('interbank_code')->references('code')->on('interbanks');
            $table->string('description');
            $table->double('debit', 16, 2)->default('0.00');
            $table->double('credit', 16, 2)->default('0.00');
            $table->double('debit_interest', 16, 2)->default('0.00');
            $table->double('credit_interest', 16, 2)->default('0.00');
            $table->string('cash')->default("K");
            $table->string('username', 50)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_mutations');
    }
};