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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->string("invoice", 25);
            $table->string('rekening')->unique();
            $table->date('date_open')->default(date("Y-m-d"));
            $table->date('date_close')->default("9999-12-31");
            $table->double('loan_amount', 16, 2);
            $table->double('loan_term', 16, 2);
            $table->double('interest_rate', 16, 2);
            $table->double('administration_fee', 16, 2);
            $table->double('provision_fee', 16, 2);
            $table->double('stamp_duty', 16, 2);

            $table->string('member_code');
            $table->string('product_loan_id');
            $table->string('username');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
