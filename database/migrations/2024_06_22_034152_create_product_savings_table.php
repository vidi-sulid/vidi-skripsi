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
        Schema::create('product_savings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('account_saving');
            $table->string('account_income_administration');
            $table->string('account_cost');
            $table->double('principal_deposit', 16, 2)->default('0.00');
            $table->double('mandatory_deposit', 16, 2)->default('0.00');
            $table->string('type', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_savings');
    }
};
