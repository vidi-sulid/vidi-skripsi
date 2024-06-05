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
        Schema::create('aset_mutations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string("invoice", 25);
            $table->string('asset_id', 8);
            $table->string('description');
            $table->double('debit_price', 16, 2)->default('0.00');
            $table->double('credit_price', 16, 2)->default('0.00');
            $table->double('debit_book_value', 16, 2)->default('0.00');
            $table->double('credit_book_value', 16, 2)->default('0.00');
            $table->timestamps();
            $table->string('username', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_mutations');
    }
};
