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
        Schema::create('savings', function (Blueprint $table) {
            $table->string('rekening');
            $table->date('date_open')->default(date("Y-m-d"));
            $table->date('date_close')->default("9999-12-31");
            $table->string("member_code");
            $table->string('product_saving_id');
            $table->string('username');

            $table->timestamps();
            $table->primary("rekening");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
